console.log("productArchive.js");

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
  // Check if any filters are currently active (have selected values)
  const hasActiveFilters = Array.from(
    document.querySelectorAll(".woo-filters select")
  ).some((select) => select.value && select.value !== "");

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
    contentSelector = ".archive-grid__content",
    excerptSelector = ".archive-grid__excerpt",
    featuredImageSelector = ".product-card__image img",
    featuredImageCaptionSelector = ".archive-grid__featured-image-caption",
    permalinkSelector = ".product-card__link",
    customFieldMappings = [],
    makeWholePostLink = true,
  } = {},
  wordpress: {
    postType = "product",
    archiveType = "category",
    customTaxonomy = null,
    termSlugs = null,
    searchTerm = null,
    postsNumber = 12,
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

  // Set initial offset according to visible posts
  const offset = document.querySelectorAll(productSelector).length;

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

    // Collect selected attributes
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

// Get current category from URL
const urlWords = window.location.pathname.split("/");
const postCategory = urlWords[2];

// Detect archive type and prepare data for API
let archiveType = "category"; // default
let termSlugs = postCategory;
let customTaxonomy = "cyclon_product_cat";

const options = {
  html: {
    customFieldMappings: [
      {
        selector: ".product-card__vehicle-icon",
        fieldName: "vehicle_type_icon",
        tag: "img",
        // renderWhenValueIs: "yes",
        // content: "Επιδοτηση εως 400€",
        property: "src",
        // insertInto: ".product-card__subsidy",
      },
      {
        selector: ".product-card__range-code",
        fieldName: "range_code",
        tag: "div",
        // renderWhenValueIs: "yes",
        // content: "Νέο",
        // property: "textContent",
        // insertInto: ".product-card__new",
      },
      {
        selector: ".product-card__info",
        fieldName: "small_text_line",
        tag: "div",
        // renderWhenValueIs: "yes",
        // content: "Νέο",
        // property: "textContent",
        // insertInto: ".product-card__new",
      },
    ],
  },
  wordpress: {
    archiveType: archiveType,
    customTaxonomy: customTaxonomy,
    termSlugs: termSlugs,
  },
};

// Function call
filterProducts(options);
