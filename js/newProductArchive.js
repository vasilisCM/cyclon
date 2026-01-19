console.log("new productArchive.js");

function getArchiveBasePath(pathname = window.location.pathname) {
  const cleaned = pathname.replace(/\/page\/\d+\/?$/, "/");
  const normalized = cleaned.replace(/\/{2,}/g, "/");
  return normalized.endsWith("/") ? normalized : `${normalized}/`;
}

function getCurrentArchivePage(pathname = window.location.pathname) {
  const match = pathname.match(/\/page\/(\d+)\//);
  return match ? parseInt(match[1], 10) : 1;
}

let archiveBasePath = getArchiveBasePath();
let currentArchivePage = getCurrentArchivePage();
let filterPinTrigger = null;

// Stick To top
function initPinElements() {
  if (typeof ScrollTrigger === "undefined") {
    return;
  }

  const stickyTarget = document.querySelector(".sticky");
  const archiveGrid = document.querySelector(".archive-grid");

  if (!stickyTarget || !archiveGrid) {
    return;
  }

  if (filterPinTrigger) {
    filterPinTrigger.kill();
    filterPinTrigger = null;
  }

  const headerHeight =
    document.querySelector(".site-header")?.offsetHeight || 0;
  const archiveGridHeight = archiveGrid?.offsetHeight || 0;

  filterPinTrigger = ScrollTrigger.create({
    trigger: stickyTarget,
    start: `-${headerHeight} top`,
    end: `+=${archiveGridHeight} bottom`, // adjust to control how long it stays pinned
    // markers: true,
    pin: true,
    pinSpacing: false, // or true if you want the placeholder spacing
  });
}

// Helper function for clearing field elements
function clearFieldElements(elements) {
  elements.forEach((element) => element.remove());
}

// Helper function for updating field elements
function updateFieldElement(element, property, value) {
  if (property === "src" || property === "href") {
    element.setAttribute(property, value);
  } else {
    element[property] = value;
  }
}

// Store initial filter options for restoration
let initialFilterOptions = {};

function storeInitialFilterOptions() {
  document.querySelectorAll(".woo-filters select").forEach((select) => {
    const attribute = select.name;
    const options = Array.from(select.options).map((option) => ({
      value: option.value,
      text: option.textContent,
    }));
    initialFilterOptions[attribute] = options;
  });
}

function updateFilterOptions(availableFilters) {
  console.log("📊 Updating filter options with available filters:", availableFilters);
  
  // Check if any filters are currently active
  // Don't count "All" options (empty value checkboxes) as active filters
  const hasActiveFilters = Array.from(
    document.querySelectorAll('input[type="checkbox"][name^="filters["]:checked, select[name^="filters["]')
  ).some((input) => {
    if (input.tagName === 'SELECT') {
      return input.value && input.value !== "";
    }
    // For checkboxes, only count as active if checked AND has a non-empty value
    return input.checked && input.value !== "";
  });

  console.log("🔍 Has active filters:", hasActiveFilters);
  console.log("📋 Available filters from API:", availableFilters);

  // Handle dropdown filters (for legacy support)
  document.querySelectorAll(".woo-filters select").forEach((select) => {
    const attribute = select.name;
    const filterItem = select.closest(".woo-filters__item");
    const selectedValue = select.value;

    // Always restore from initial options first
    if (initialFilterOptions[attribute]) {
      select.innerHTML = "";
      initialFilterOptions[attribute].forEach((optionData) => {
        const option = document.createElement("option");
        option.value = optionData.value;
        option.textContent = optionData.text;
        if (optionData.value === selectedValue) {
          option.selected = true;
        }

        // If filters are active and this term isn't available, disable it
        if (hasActiveFilters && availableFilters[attribute]) {
          const isAvailable = availableFilters[attribute].hasOwnProperty(
            optionData.value
          );
          option.disabled = !isAvailable && optionData.value !== ""; // Don't disable empty option
        }

        select.appendChild(option);
      });

      if (filterItem) {
        filterItem.style.display = "block";
      }
    } else {
      // Fallback: show just the default option
      const label =
        select.getAttribute("data-label") || select.name.replace("pa_", "");
      select.innerHTML = `<option value="">${label}</option>`;

      if (filterItem) {
        filterItem.style.display = "block";
      }
    }
  });

  // Handle checkbox and dropdown filters (new product archive)
  const taxonomies = cyclonFilters?.taxonomies || [];
  
  taxonomies.forEach((taxonomy) => {
    // Handle checkboxes
    const checkboxes = document.querySelectorAll(
      `input[name="filters[${taxonomy}][]"]`
    );
    
    if (checkboxes.length > 0) {
      checkboxes.forEach((checkbox) => {
        const termSlug = checkbox.value;
        const optionDiv = checkbox.closest('.product-filters__option');
        
        // ALWAYS enable "All" options (empty value checkboxes like "All Ranges")
        if (termSlug === "") {
          checkbox.disabled = false;
          if (optionDiv) {
            optionDiv.style.opacity = '1';
            optionDiv.style.pointerEvents = 'auto';
          }
        } else if (hasActiveFilters && availableFilters[taxonomy]) {
          const isAvailable = availableFilters[taxonomy].hasOwnProperty(termSlug);
          checkbox.disabled = !isAvailable && !checkbox.checked;
          
          // Add visual feedback
          if (optionDiv) {
            if (checkbox.disabled) {
              optionDiv.style.opacity = '0.5';
              optionDiv.style.pointerEvents = 'none';
            } else {
              optionDiv.style.opacity = '1';
              optionDiv.style.pointerEvents = 'auto';
            }
          }
          
          console.log(`  ${taxonomy} - ${termSlug}: ${isAvailable ? 'available' : 'disabled'}`);
        } else {
          // No active filters, enable all
          checkbox.disabled = false;
          if (optionDiv) {
            optionDiv.style.opacity = '1';
            optionDiv.style.pointerEvents = 'auto';
          }
        }
      });
    }
    
    // Handle dropdowns
    const dropdown = document.querySelector(`select[name="filters[${taxonomy}][]"]`);
    if (dropdown) {
      Array.from(dropdown.options).forEach((option) => {
        if (option.value === "") return; // Skip "All" option
        
        if (hasActiveFilters && availableFilters[taxonomy]) {
          const isAvailable = availableFilters[taxonomy].hasOwnProperty(option.value);
          option.disabled = !isAvailable && option.value !== dropdown.value;
        } else {
          option.disabled = false;
        }
      });
    }
  });
}

// Main function
async function filterProducts({
  html: {
    containerSelector = ".archive-grid",
    productSelector = ".product-card",
    // buttonSelector = ".button--load-more",
    noMorePostsSelector = ".archive-grid__no-more-posts",
    loaderClass = "archive-grid__loader",
    titleSelector = ".product-card__title",
    featuredImageSelector = ".product-card__image img",
    permalinkSelector = ".product-card__link",
    customFieldMappings = [],
    makeWholePostLink = true,
  } = {},
  wordpress: {
    postType = "cyclon_new_product",
    archiveType = "category",
    customTaxonomy = null,
    termSlugs = null,
    searchTerm = null,
    postsNumber = 8,
    page = 1,
    urlFilters = {},
  } = {},
} = {}) {
  // Store initial filter options on first call
  if (Object.keys(initialFilterOptions).length === 0) {
    storeInitialFilterOptions();
  }

  // Get elements
  const container = document.querySelector(containerSelector);
  const loadMoreBtn = document.querySelector(".archive-grid__load-more");
  const noMorePostsText = document.querySelector(noMorePostsSelector);

  // Set initial offset according to visible posts (only if no filters are active)
  const hasActiveFilters = urlFilters && Object.keys(urlFilters).length > 0;
  const offset = hasActiveFilters
    ? 0
    : document.querySelectorAll(productSelector).length;

  if (!container) {
    console.error("Container or button selector is incorrect.");
    return;
  }

  // Reset "No more Products" message and show Load More button
  if (noMorePostsText) {
    noMorePostsText.style.display = "none";
  }
  if (loadMoreBtn) {
    loadMoreBtn.style.display = "flex";
  }

  // Replace the button with a loader
  const loader = document.querySelector(`.${loaderClass}`);
  loader.classList.remove("hidden");

  // Show the loading overlay
  const loaderOverlay = document.querySelector(
    ".woo-archive-options__loader-overlay"
  );
  if (loaderOverlay) {
    loaderOverlay.classList.remove("invisible");
  }

  try {
    // Prepare form data
    const formData = new FormData();
    formData.append("action", "filter_products");
    formData.append("postType", postType);
    if (customTaxonomy) formData.append("customTaxonomy", customTaxonomy);
    if (termSlugs) formData.append("termSlugs", termSlugs);
    if (searchTerm) formData.append("searchTerm", searchTerm);
    formData.append("postsNumber", postsNumber);
    formData.append("page", page);

    // Add archive type information
    if (archiveType) formData.append("archiveType", archiveType);
    formData.append("offset", offset);

    // Make AJAX request
    const apiEndPoint = wpAjax.ajaxUrl;

    // Add current archive context if available
    if (
      window.currentArchiveContext &&
      Object.keys(window.currentArchiveContext).length > 0
    ) {
      formData.append(
        "current_archive_context",
        JSON.stringify(window.currentArchiveContext)
      );
    }

    // Add URL-based filters (from checkboxes)
    if (urlFilters && Object.keys(urlFilters).length > 0) {
      console.log("🔍 Adding URL filters:", urlFilters);
      Object.keys(urlFilters).forEach((taxonomy) => {
        const values = urlFilters[taxonomy];
        if (Array.isArray(values)) {
          values.forEach((value) => {
            formData.append(`filters[${taxonomy}][]`, value);
          });
        }
      });
    }

    // Collect selected attributes (legacy support for select dropdowns)
    console.log("🔍 Collecting filter values:");
    document.querySelectorAll(".woo-filters select").forEach((select) => {
      if (select.value) {
        console.log(`  - ${select.name}: ${select.value}`);
        formData.append(select.name, select.value);
      }
    });

    // Log all form data being sent
    console.log("📤 Form data being sent to backend:");
    for (let [key, value] of formData.entries()) {
      console.log(`  - ${key}: ${value}`);
    }

    const response = await fetch(apiEndPoint, {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      console.error("Network response was not ok:", response);
      throw new Error("Network response was not ok");
    }

    const data = await response.json();
    console.log("Filtered Products:", data);

    // Log debug info from backend
    if (data.debug_info) {
      console.log("🔍 Backend Debug Info:", data.debug_info);
      console.log("📂 Applied Filters:", data.debug_info.applied_filters);
      console.log("📋 Final Query Args:", data.debug_info.final_query_args);
    }

    // Update product count display
    const productCountElement = document.querySelector(
      ".woo-sorting__product-count"
    );
    if (productCountElement) {
      const totalProducts = data.total_products || data.products.length;
      console.log("📊 Product count update:", {
        total_products: data.total_products,
        products_length: data.products.length,
        using: totalProducts,
      });
      const productCountText =
        totalProducts === 1
          ? `${totalProducts} product`
          : `${totalProducts} products`;
      productCountElement.textContent = productCountText;
    }

    // Update filter dropdowns dynamically
    updateFilterOptions(data.available_filters);

    if (!data) {
      throw new Error("Invalid response from API");
    }

    const productsInfo = data.products;
    // const totalProducts = data.totalProducts;
    console.log(productsInfo);

    const templateElement = document.querySelector(productSelector);
    if (!templateElement) {
      console.error("No product template found.");
      return;
    }
    const templateClone = templateElement.cloneNode(true);

    Array.from(container.children).forEach((child) => {
      if (!child.classList.contains(loaderClass)) {
        child.remove();
      }
    });

    if (productsInfo.length > 0) {
      productsInfo.forEach((post) => {
        // Clone an existing post to use as a template
        const template = templateClone.cloneNode(true);

        // Remove existing elements for mapped fields
        const elementInfo = customFieldMappings.flatMap((mapping) => {
          const fieldElements = template.querySelectorAll(mapping.selector);
          if (fieldElements.length > 0) {
            const firstElement = fieldElements[0];
            const classList = [...firstElement.classList];
            const parent = firstElement.parentNode;
            clearFieldElements(Array.from(fieldElements));
            return [{ mapping, classList, parent }];
          }
          return [];
        });

        // Update the cloned template with new data
        const titleElement = template.querySelector(titleSelector);
        const priceElement = template.querySelector(".product-card__price");
        // Update the Add to Cart button
        const addToCartElement = template.querySelector(
          ".product-card__add-to-cart"
        );

        // const contentElement = template.querySelector(contentSelector);
        // const excerptElement = template.querySelector(excerptSelector);
        const featuredImageElement = template.querySelector(
          featuredImageSelector
        );
        // const featuredImageCaptionElement = template.querySelector(
        //   featuredImageCaptionSelector
        // );

        // Paint UI
        // Title
        if (titleElement) titleElement.innerHTML = post.title; // Update the price

        if (priceElement) {
          priceElement.innerHTML = post.price_html; // Replace entire HTML to maintain WooCommerce's markup
        }

        if (addToCartElement) {
          // Replace the entire element instead of just setting innerHTML to avoid nested <a> tags
          const tempDiv = document.createElement("div");
          tempDiv.innerHTML = post.add_to_cart_html;
          const newAddToCartElement = tempDiv.firstElementChild;

          if (newAddToCartElement) {
            addToCartElement.replaceWith(newAddToCartElement);
          }
        }

        // Content
        // if (contentElement) contentElement.innerHTML = post.content;
        // Excerpt
        // if (excerptElement) excerptElement.innerHTML = post.excerpt;
        // Image

        if (featuredImageElement) {
          featuredImageElement.src = post.image ?? "";
          featuredImageElement.alt = post.title ?? "";
        } else {
          const featuredImageContainer = template.querySelector(
            featuredImageSelector.split(" ")[0]
          );
          if (featuredImageContainer) {
            featuredImageContainer.innerHTML = `<img src="${
              post.image ?? ""
            }" alt="${post.title ?? ""}">`;
          }
        }

        // Image Caption
        // if (featuredImageCaptionElement)
        //   featuredImageCaptionElement.innerHTML = post.image_caption;

        // Range Display (e.g., "Cyclon EVO")
        const rangeElement = template.querySelector(".text-ms.uppercase");
        if (rangeElement && post.range_display) {
          // Keep the "Cyclon " prefix and add the range
          rangeElement.innerHTML = `<span>Cyclon </span>${post.range_display}`;
        }

        // Product Grade with color
        const gradeElement = template.querySelector(".product-card__grade");
        if (gradeElement && post.grade) {
          gradeElement.textContent = post.grade.name;
          if (post.grade.color) {
            gradeElement.style.color = post.grade.color;
          }
        }

        // ACF
        elementInfo.forEach(({ mapping, classList, parent }) => {
          let value = post.custom_fields[mapping.fieldName];

          // Only render if matches condition (optional)
          if (
            mapping.renderWhenValueIs !== undefined &&
            value !== mapping.renderWhenValueIs
          ) {
            return;
          }

          const targetContainer = mapping.insertInto
            ? template.querySelector(mapping.insertInto)
            : parent;

          if (!targetContainer) return;

          if (Array.isArray(value) && mapping.isRepeater) {
            value.forEach((subValue) => {
              const newElement = document.createElement(mapping.tag);
              newElement.classList.add(...classList);
              const safeValue = mapping.content ?? subValue ?? "";
              updateFieldElement(
                newElement,
                mapping.property ?? "textContent",
                safeValue
              );
              targetContainer.appendChild(newElement);
            });
          } else {
            const newElement = document.createElement(mapping.tag);
            newElement.classList.add(...classList);
            const safeValue = mapping.content ?? value ?? "";
            updateFieldElement(
              newElement,
              mapping.property ?? "textContent",
              safeValue
            );
            targetContainer.appendChild(newElement);
          }
        });

        // Content Excerpt - Add after ACF processing
        if (post.content_excerpt) {
          const productCardContent = template.querySelector(".productCard__Content");
          if (productCardContent) {
            // Create the content excerpt div
            const excerptDiv = document.createElement("div");
            excerptDiv.className = "text-s info product-card__info";
            excerptDiv.textContent = post.content_excerpt;
            
            // Find the last h4 element to insert before it
            const h4Element = productCardContent.querySelector("h4.home-categories__category-heading");
            if (h4Element) {
              productCardContent.insertBefore(excerptDiv, h4Element);
            } else {
              // Fallback: append at the end if h4 not found
              productCardContent.appendChild(excerptDiv);
            }
          }
        }

        if (makeWholePostLink) {
          const linkElement = template.querySelector(permalinkSelector);
          if (linkElement) {
            linkElement.href = post.permalink;
          } else {
            template.href = post.permalink;
          }
        }

        // Append the updated template to the container
        container.appendChild(template);
      });

      loader.classList.add("hidden");

      // Hide the loading overlay
      if (loaderOverlay) {
        loaderOverlay.classList.add("invisible");
      }
      //   loader.replaceWith(button);
    }

    const paginationContainer = document.querySelector(".archive-grid__bottom");
    if (paginationContainer && "pagination_html" in data) {
      paginationContainer.innerHTML = data.pagination_html || "";
    }

    if (typeof ScrollTrigger !== "undefined") {
      initPinElements();
      ScrollTrigger.refresh();
    }

    // UP TO HERE!

    // else {
    //   if (noMorePostsText) {
    //     noMorePostsText.style.display = "block";
    //   }
    //   loader.replaceWith(button);
    //   button.style.display = "none";
    // }
  } catch (error) {
    console.error("Error fetching posts:", error);

    // Hide the loading overlay on error
    const loaderOverlay = document.querySelector(
      ".woo-archive-options__loader-overlay"
    );
    if (loaderOverlay) {
      loaderOverlay.classList.add("invisible");
    }

    // loader.replaceWith(button);
    // if (noMorePostsText) {
    //   noMorePostsText.style.display = "block";
    // }
    // button.style.display = "none";
  }
}

// URL-based filter management
function getUrlParams() {
  const params = new URLSearchParams(window.location.search);
  const filters = {};

  // Get all filter taxonomies from localized variable
  const taxonomies = cyclonFilters?.taxonomies || [];

  taxonomies.forEach((taxonomy) => {
    const value = params.get(taxonomy);
    if (value) {
      // Support comma-separated values for multiple selections
      filters[taxonomy] = value.split(",").filter((v) => v.trim() !== "");
    }
  });

  return filters;
}

function updateUrlFromFilters() {
  const filters = {};
  const taxonomies = cyclonFilters?.taxonomies || [];

  // Collect values from both checkboxes and dropdowns
  taxonomies.forEach((taxonomy) => {
    // Check for checkboxes first
    const checkboxes = document.querySelectorAll(`input[name="filters[${taxonomy}][]"]:checked`);
    if (checkboxes.length > 0) {
      // Filter out empty values (for "All" options)
      const checked = Array.from(checkboxes)
        .map((cb) => cb.value)
        .filter((val) => val !== "");
      
      if (checked.length > 0) {
        filters[taxonomy] = checked.join(",");
      }
    } else {
      // Check for dropdown (select)
      const dropdown = document.querySelector(`select[name="filters[${taxonomy}][]"]`);
      if (dropdown && dropdown.value && dropdown.value !== "") {
        filters[taxonomy] = dropdown.value;
      }
    }
  });

  // Update URL without page reload
  const url = new URL(window.location);
  currentArchivePage = 1;
  url.pathname = archiveBasePath;
  archiveBasePath = getArchiveBasePath(url.pathname);

  // Remove all filter params first
  taxonomies.forEach((taxonomy) => {
    url.searchParams.delete(taxonomy);
  });

  // Add current filter params
  Object.keys(filters).forEach((taxonomy) => {
    url.searchParams.set(taxonomy, filters[taxonomy]);
  });

  // Update URL without reload
  window.history.pushState({}, "", url);

  // Update selected filters display
  updateSelectedFiltersDisplay();

  // Trigger filter update
  applyFiltersFromUrl();
}

function syncFiltersFromUrl() {
  const urlFilters = getUrlParams();
  const taxonomies = cyclonFilters?.taxonomies || [];

  taxonomies.forEach((taxonomy) => {
    // Sync checkboxes
    const checkboxes = document.querySelectorAll(
      `input[name="filters[${taxonomy}][]"]`
    );
    const urlValues = urlFilters[taxonomy] || [];

    checkboxes.forEach((checkbox) => {
      checkbox.checked = urlValues.includes(checkbox.value);
      
      // Update active class for cyclon_range
      if (taxonomy === 'cyclon_range') {
        const optionDiv = checkbox.closest('.product-filters__option');
        if (optionDiv) {
          optionDiv.classList.toggle('active', checkbox.checked);
        }
      }
    });

    // Special handling for cyclon_range "All Ranges" checkbox
    if (taxonomy === 'cyclon_range') {
      const allRangesCheckbox = document.querySelector(
        `input[name="filters[${taxonomy}][]"][value=""]`
      );
      
      if (allRangesCheckbox) {
        // If no range filters in URL, check "All Ranges"
        const hasRangeFilters = urlValues.length > 0 && urlValues.some(val => val !== "");
        allRangesCheckbox.checked = !hasRangeFilters;
        
        const allOptionDiv = allRangesCheckbox.closest('.product-filters__option');
        if (allOptionDiv) {
          allOptionDiv.classList.toggle('active', !hasRangeFilters);
        }
      }
    }

    // Sync dropdowns
    const dropdown = document.querySelector(`select[name="filters[${taxonomy}][]"]`);
    if (dropdown && urlValues.length > 0) {
      dropdown.value = urlValues[0]; // Dropdowns only support single selection
    } else if (dropdown) {
      dropdown.selectedIndex = 0; // Reset to first option
    }
  });

  // Update selected filters display
  updateSelectedFiltersDisplay();
}

function updateSelectedFiltersDisplay() {
  const selectedFiltersContainer = document.querySelector(".selected-filters");
  const selectedFiltersList = document.querySelector(".selected-filters__list");

  if (!selectedFiltersContainer || !selectedFiltersList) return;

  const urlFilters = getUrlParams();
  const taxonomies = cyclonFilters?.taxonomies || [];

  // Clear existing filters
  selectedFiltersList.innerHTML = "";

  // Get taxonomy labels (from the h4 elements in filter groups)
  const taxonomyLabels = {};
  taxonomies.forEach((taxonomy) => {
    const filterGroup = document.querySelector(`.taxonomy-${taxonomy}`);
    if (filterGroup) {
      const labelElement = filterGroup.querySelector("h4");
      taxonomyLabels[taxonomy] = labelElement
        ? labelElement.textContent.trim()
        : taxonomy;
    }
  });

  // Build selected filters list
  let hasActiveFilters = false;

  taxonomies.forEach((taxonomy) => {
    const urlValues = urlFilters[taxonomy] || [];

    urlValues.forEach((termSlug) => {
      let termName = termSlug;

      // Try to find the checkbox and its label first
      const checkbox = document.querySelector(
        `input[name="filters[${taxonomy}][]"][value="${termSlug}"]`
      );

      if (checkbox) {
        const label = checkbox
          .closest(".product-filters__option")
          ?.querySelector("label");
        termName = label ? label.textContent.trim() : termSlug;
      } else {
        // If not a checkbox, check for dropdown option
        const dropdown = document.querySelector(`select[name="filters[${taxonomy}][]"]`);
        if (dropdown) {
          const option = dropdown.querySelector(`option[value="${termSlug}"]`);
          termName = option ? option.textContent.trim() : termSlug;
        }
      }

      const taxonomyLabel = taxonomyLabels[taxonomy] || taxonomy;

      const filterItem = document.createElement("div");
      filterItem.className = "selected-filters__item";

      // const taxonomySpan = document.createElement("span");
      // taxonomySpan.className = "selected-filters__taxonomy";
      // taxonomySpan.textContent = taxonomyLabel + ":";

      const termSpan = document.createElement("span");
      termSpan.className = "selected-filters__term";
      termSpan.textContent = termName;

      const removeBtn = document.createElement("div");
      removeBtn.type = "button";
      removeBtn.className = "selected-filters__remove";
      removeBtn.setAttribute("data-taxonomy", taxonomy);
      removeBtn.setAttribute("data-term", termSlug);
      removeBtn.setAttribute("aria-label", "Remove filter");
      removeBtn.textContent = "×";

      // filterItem.appendChild(taxonomySpan);
      filterItem.appendChild(termSpan);
      filterItem.appendChild(removeBtn);

      selectedFiltersList.appendChild(filterItem);
      hasActiveFilters = true;
    });
  });

  // Show/hide the selected filters container
  selectedFiltersContainer.style.display = hasActiveFilters ? "block" : "none";
}

function clearAllFilters() {
  const taxonomies = cyclonFilters?.taxonomies || [];

  // Clear all filter checkboxes and dropdowns
  taxonomies.forEach((taxonomy) => {
    // Uncheck checkboxes
    const checkboxes = document.querySelectorAll(
      `input[name="filters[${taxonomy}][]"]:checked`
    );
    checkboxes.forEach((checkbox) => {
      checkbox.checked = false;
    });

    // Reset dropdowns
    const dropdown = document.querySelector(`select[name="filters[${taxonomy}][]"]`);
    if (dropdown) {
      dropdown.selectedIndex = 0;
    }
  });

  // Update URL (which will trigger filter update)
  updateUrlFromFilters();
}

function removeFilter(taxonomy, termSlug) {
  // Find and uncheck the specific checkbox
  const checkbox = document.querySelector(
    `input[name="filters[${taxonomy}][]"][value="${termSlug}"]`
  );

  if (checkbox) {
    checkbox.checked = false;
  } else {
    // If not a checkbox, check for dropdown
    const dropdown = document.querySelector(`select[name="filters[${taxonomy}][]"]`);
    if (dropdown && dropdown.value === termSlug) {
      dropdown.selectedIndex = 0; // Reset to first option
    }
  }

  // Update URL (which will trigger filter update)
  updateUrlFromFilters();
}

// Function Call
function applyFiltersFromUrl() {
  const urlFilters = getUrlParams();

  // Get current category from URL
  const urlWords = window.location.pathname.split("/");
  const postCategory = urlWords[2];

  // Detect archive type and prepare data for API
  let archiveType = "category"; // default
  let termSlugs = postCategory;
  let customTaxonomy = "cyclon_new_product_cat";

  const options = {
    html: {
      customFieldMappings: [
        {
          selector: ".product-card__vehicle-icon",
          fieldName: "vehicle_type_icon",
          tag: "img",
          property: "src",
        },
        {
          selector: ".product-card__range-code",
          fieldName: "range_code",
          tag: "div",
        },
        {
          selector: ".product-card__info",
          fieldName: "small_text_line",
          tag: "div",
        },
      ],
    },
    wordpress: {
      archiveType: archiveType,
      customTaxonomy: customTaxonomy,
      termSlugs: termSlugs,
      page: currentArchivePage,
      urlFilters: urlFilters, // Pass URL filters
    },
  };

  filterProducts(options);
}

// Fetch initial available filters on page load
async function fetchInitialAvailableFilters() {
  try {
    const urlWords = window.location.pathname.split("/");
    const postCategory = urlWords[2];
    
    const formData = new FormData();
    formData.append("action", "filter_products");
    formData.append("postType", "cyclon_new_product");
    formData.append("customTaxonomy", "cyclon_new_product_cat");
    formData.append("termSlugs", postCategory);
    formData.append("postsNumber", -1); // Get all to check availability
    formData.append("page", 1);
    
    const response = await fetch(wpAjax.ajaxUrl, {
      method: "POST",
      body: formData,
    });
    
    if (response.ok) {
      const data = await response.json();
      if (data.available_filters) {
        console.log("📥 Initial available filters loaded:", data.available_filters);
        // Don't update filter options on initial load - show all by default
        // They will be filtered when user applies filters
      }
    }
  } catch (error) {
    console.error("Error fetching initial filters:", error);
  }
}

// Initialize: Set up checkbox and dropdown listeners and URL sync
document.addEventListener("DOMContentLoaded", () => {
  // Sync filters (checkboxes and dropdowns) from URL on page load
  syncFiltersFromUrl();
  
  // Fetch initial available filters (but don't disable anything yet)
  // fetchInitialAvailableFilters();

  // Listen for checkbox changes to modify the URL
  document
    .querySelectorAll('input[type="checkbox"][name^="filters["]')
    .forEach((checkbox) => {
      checkbox.addEventListener("change", updateUrlFromFilters);
    });

  // Special handling for cyclon_range: make the entire div clickable
  document
    .querySelectorAll('.taxonomy-cyclon_range .product-filters__option')
    .forEach((optionDiv) => {
      // Set initial active state based on checkbox
      const checkbox = optionDiv.querySelector('input[type="checkbox"]');
      if (checkbox && checkbox.checked) {
        optionDiv.classList.add('active');
      }
      
      optionDiv.addEventListener("click", (e) => {
        // Don't trigger if clicking on the checkbox or label directly
        // (let the native behavior handle it)
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'LABEL') {
          return;
        }
        
        // Find and toggle the checkbox
        if (checkbox) {
          checkbox.checked = !checkbox.checked;
          // Toggle active class
          optionDiv.classList.toggle('active', checkbox.checked);
          // Manually trigger the change event
          checkbox.dispatchEvent(new Event('change', { bubbles: true }));
        }
      });
      
      // Also update active class when checkbox changes (for label clicks)
      if (checkbox) {
        checkbox.addEventListener('change', () => {
          optionDiv.classList.toggle('active', checkbox.checked);
        });
      }
    });

  // Special logic for cyclon_range "All Ranges" option
  const rangeCheckboxes = document.querySelectorAll('input[name="filters[cyclon_range][]"]');
  const allRangesCheckbox = document.querySelector('input[name="filters[cyclon_range][]"][value=""]');
  
  if (allRangesCheckbox && rangeCheckboxes.length > 0) {
    rangeCheckboxes.forEach((checkbox) => {
      checkbox.addEventListener('change', () => {
        if (checkbox === allRangesCheckbox) {
          // "All Ranges" was clicked - uncheck all other ranges
          if (checkbox.checked) {
            rangeCheckboxes.forEach((cb) => {
              if (cb !== allRangesCheckbox && cb.checked) {
                cb.checked = false;
                // Dispatch change event to trigger active class update
                cb.dispatchEvent(new Event('change', { bubbles: true }));
              }
            });
          }
        } else {
          // A specific range was clicked - uncheck "All Ranges"
          if (checkbox.checked && allRangesCheckbox.checked) {
            allRangesCheckbox.checked = false;
            // Dispatch change event to trigger active class update
            allRangesCheckbox.dispatchEvent(new Event('change', { bubbles: true }));
          }
          
          // If no ranges are selected, check "All Ranges"
          const anyRangeChecked = Array.from(rangeCheckboxes).some(
            (cb) => cb !== allRangesCheckbox && cb.checked
          );
          if (!anyRangeChecked) {
            allRangesCheckbox.checked = true;
            // Dispatch change event to trigger active class update
            allRangesCheckbox.dispatchEvent(new Event('change', { bubbles: true }));
          }
        }
      });
    });
  }

  // Listen for dropdown changes to modify the URL
  document
    .querySelectorAll('select[name^="filters["]')
    .forEach((dropdown) => {
      dropdown.addEventListener("change", updateUrlFromFilters);
    });

  // Clear all filters button
  const clearAllBtn = document.querySelector(".selected-filters__clear-all");
  if (clearAllBtn) {
    clearAllBtn.addEventListener("click", clearAllFilters);
  }

  // Remove individual filter buttons (delegated event listener)
  document.addEventListener("click", (e) => {
    if (e.target.classList.contains("selected-filters__remove")) {
      const taxonomy = e.target.getAttribute("data-taxonomy");
      const term = e.target.getAttribute("data-term");
      if (taxonomy && term) {
        removeFilter(taxonomy, term);
      }
    }
  });

  // Listen for browser back/forward buttons
  window.addEventListener("popstate", () => {
    archiveBasePath = getArchiveBasePath();
    currentArchivePage = getCurrentArchivePage();
    syncFiltersFromUrl();
    applyFiltersFromUrl();
    initPinElements();
    ScrollTrigger.refresh();
  });

  // Initial display of selected filters (if any in URL)
  updateSelectedFiltersDisplay();
  initPinElements();
  ScrollTrigger.refresh();
});
