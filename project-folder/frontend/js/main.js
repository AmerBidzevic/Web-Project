import AuthService from "./services/AuthService.js"
import ApiService from "./services/ApiService.js"
;("use strict")

// Dropdown on mouse hover
function toggleNavbarMethod() {
  if ($(window).width() > 992) {
    $(".navbar .dropdown")
      .on("mouseover", function () {
        $(".dropdown-toggle", this).trigger("click")
      })
      .on("mouseout", function () {
        $(".dropdown-toggle", this).trigger("click").blur()
      })
  } else {
    $(".navbar .dropdown").off("mouseover").off("mouseout")
  }
}

// Back to top button
function backToTopHandler() {
  if ($(window).scrollTop() > 100) {
    $(".back-to-top").fadeIn("slow")
  } else {
    $(".back-to-top").fadeOut("slow")
  }
}

// Update active navigation link based on hash
function updateActiveNav() {
  var currentView = window.location.hash || "#home"
  var baseView = currentView.split("/")[0]

  $(".nav-item").removeClass("active")

  if (baseView === "#home") {
    $('.nav-link[href="#home"]').addClass("active")
  } else if (baseView === "#shop") {
    $('.nav-link[href="#shop"]').addClass("active")
  } else if (baseView === "#contact") {
    $('.nav-link[href="#contact"]').addClass("active")
  } else if (baseView === "#shopping_cart") {
    $('.nav-link[href="#shopping_cart"]').addClass("active")
  } else if (baseView === "#detailed_product") {
    $('.nav-link[href="#detailed_product"]').addClass("active")
  }
}
function updateAuthUI() {
  const token = localStorage.getItem("jwt_token")
  const user = JSON.parse(localStorage.getItem("user"))

  console.log("Current user:", user)

  if (token && user) {
    $("#login-btn").hide()
    $("#sign_up-btn").hide()
    $("#user-profile").text(user.email).show()
    $("#logout-button").show()
    $(".btn[href='#shopping_cart']").show()

    updateCartBadge()

    console.log("User role:", user.role)
    console.log("Admin link element:", $("#admin-link").length)

    if (user.role === "admin") {
      console.log("Showing admin link")
      $("#admin-link").show()
    } else {
      console.log("Hiding admin link")
      $("#admin-link").hide()
    }
  } else {
    console.log("User not logged in - resetting UI")
    $("#login-btn").show()
    $("#sign_up-btn").show()
    $("#user-profile").hide()
    $("#logout-button").hide()
    $("#admin-link").hide()
    $(".btn[href='#shopping_cart']").hide()

    updateCartBadge()
  }
}

async function authFetch(url, options = {}) {
  return ApiService.authFetch(url, options)
}

$(document).ready(function () {
  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    return re.test(email)
  }

  function validatePassword(password) {
    return password.length >= 8
  }

  function validateUsername(username) {
    return username.length >= 3
  }

  // Init dropdown hover method and window resize
  toggleNavbarMethod()
  $(window).resize(toggleNavbarMethod)

  // Back to top button scroll event
  $(window).scroll(backToTopHandler)
  backToTopHandler()

  // Back to top button click
  $(".back-to-top").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 1500, "swing")
    return false
  })

  // Owl carousel - vendor
  $(".vendor-carousel").owlCarousel({
    loop: true,
    margin: 29,
    nav: false,
    autoplay: true,
    smartSpeed: 1000,
    responsive: {
      0: { items: 2 },
      576: { items: 3 },
      768: { items: 4 },
      992: { items: 5 },
      1200: { items: 6 }
    }
  })

  // Owl carousel - related
  $(".related-carousel").owlCarousel({
    loop: true,
    margin: 29,
    nav: false,
    autoplay: true,
    smartSpeed: 1000,
    responsive: {
      0: { items: 1 },
      576: { items: 2 },
      768: { items: 3 },
      992: { items: 4 }
    }
  })

  // Product quantity buttons
  $(document).on("click", ".quantity button", function () {
    var button = $(this)
    var oldValue = button.closest(".quantity").find("input").val()

    if (button.hasClass("btn-plus")) {
      var newVal = parseFloat(oldValue) + 1
    } else {
      if (oldValue > 0) {
        var newVal = parseFloat(oldValue) - 1
      } else {
        newVal = 0
      }
    }

    button.closest(".quantity").find("input").val(newVal)
  })

  updateAuthUI()

  $("#login-btn").click(function () {
    $(".modal-title").text("Login")
    $("#login-form").show()
    $("#signup-form").hide()
    $("#toggle-form").text("Don't have an account? Sign Up")
    $("#toggle-to-login").hide()
    $("#myModal").modal("show")
  })

  $("#sign_up-btn").click(function () {
    $(".modal-title").text("Sign Up")
    $("#signup-form").show()
    $("#login-form").hide()
    $("#toggle-form").text("Already a member? Login")
    $("#toggle-to-login").show()
    $("#myModal").modal("show")
  })

  $("#toggle-form").click(function () {
    if ($(".modal-title").text() === "Sign Up") {
      $(".modal-title").text("Login")
      $("#login-form").show()
      $("#signup-form").hide()
      $("#toggle-form").text("Don't have an account? Sign Up")
      $("#toggle-to-login").hide()
    } else {
      $(".modal-title").text("Sign Up")
      $("#signup-form").show()
      $("#login-form").hide()
      $("#toggle-form").text("Already a member? Login")
      $("#toggle-to-login").show()
    }
  })

  $("#toggle-to-login").click(function () {
    $(".modal-title").text("Login")
    $("#login-form").show()
    $("#signup-form").hide()
    $("#toggle-form").text("Don't have an account? Sign Up")
    $("#toggle-to-login").hide()
  })

  // Handle login form submission using AuthService (MVC)
  $(document).on("submit", "#actual-login-form", async function (e) {
    e.preventDefault()
    const email = $("#email").val().trim()
    const password = $("#psw").val()

    // Clear previous validation styles and messages
    $("#email, #psw").removeClass("is-invalid")
    $("#email").next(".invalid-feedback").remove()
    $("#psw").next(".invalid-feedback").remove()

    let isValid = true

    if (!email) {
      $("#email").addClass("is-invalid").after('<div class="invalid-feedback">Please enter your email</div>')
      isValid = false
    } else if (!validateEmail(email)) {
      $("#email").addClass("is-invalid").after('<div class="invalid-feedback">Please enter a valid email</div>')
      isValid = false
    }

    if (!password) {
      $("#psw").addClass("is-invalid").after('<div class="invalid-feedback">Please enter your password</div>')
      isValid = false
    }

    if (!isValid) return false

    try {
      const data = await AuthService.login(email, password)

      if (data.message && data.message.toLowerCase().includes("successful")) {
        localStorage.setItem("jwt_token", data.data.token)
        localStorage.setItem("user", JSON.stringify(data.data.user))
        updateAuthUI()
        $("#myModal").modal("hide")
        $(".modal-backdrop").remove()
        $("body").removeClass("modal-open")
        window.location.href = "#home"
      } else {
        alert(data.error || data.message || "Login failed")
      }
    } catch (error) {
      if (error.message && error.message.toLowerCase().includes("password")) {
        $("#psw").addClass("is-invalid").after(`<div class="invalid-feedback">${error.message}</div>`)
      } else {
        alert(error.message || "Login failed. Please check your connection and try again.")
      }
    }
  })

  // Handle signup form submission using AuthService (MVC)
  $(document).on("submit", "#actual-signup-form", async function (e) {
    e.preventDefault()
    const email = $("#new-email").val()
    const username = $("#new-username").val()
    const password = $("#new-psw").val()

    // You can add validation here if needed

    try {
      const data = await AuthService.register(username, email, password)

      if (data.message && data.message.toLowerCase().includes("successful")) {
        alert("Registration successful! Please login.")
        $(".modal-title").text("Login")
        $("#login-form").show()
        $("#signup-form").hide()
        $("#toggle-form").text("Don't have an account? Sign Up")
        $("#toggle-to-login").hide()
      } else {
        alert(data.error || data.message || "Registration failed")
      }
    } catch (error) {
      alert(error.message || "Registration failed. Please check your connection and try again.")
    }
  })

  // Logout using AuthService (MVC)
  $("#logout-button").click(function () {
    AuthService.logout()
    localStorage.removeItem(getCartKey())
    updateAuthUI()
  })

  updateActiveNav()

  $(window).on("hashchange", updateActiveNav)
})

//Contact logic/ validation

$(document).on("submit", "#contactForm", function (e) {
  e.preventDefault()

  const name = $("#name").val().trim()
  const email = $("#contactEmail").val().trim()
  const subject = $("#subject").val().trim()
  const message = $("#message").val().trim()

  $(".form-control").removeClass("is-invalid")
  $(".help-block").text("")
  $("#success").empty()

  let isValid = true

  if (!name) {
    $("#name").addClass("is-invalid")
    $("#name").closest(".control-group").find(".help-block").text("Please enter your name")
    isValid = false
  }

  if (!email) {
    $("#contactEmail").addClass("is-invalid")
    $("#contactEmail").closest(".control-group").find(".help-block").text("Please enter your email")
    isValid = false
  } else if (!validateEmail(email)) {
    $("#contactEmail").addClass("is-invalid")
    $("#contactEmail").closest(".control-group").find(".help-block").text("Please enter a valid email")
    isValid = false
  }

  if (!subject) {
    $("#subject").addClass("is-invalid")
    $("#subject").closest(".control-group").find(".help-block").text("Please enter a subject")
    isValid = false
  }

  if (!message) {
    $("#message").addClass("is-invalid")
    $("#message").closest(".control-group").find(".help-block").text("Please enter your message")
    isValid = false
  }

  if (!isValid) return

  const submitBtn = $(this).find("button[type='submit']")
  submitBtn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Sending...')
})

function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return re.test(email)
}

//**************************************************************************************************************
//Product Loading
document.addEventListener("DOMContentLoaded", function () {
  loadFeaturedProducts()
  loadRecentProducts()
})

async function loadFeaturedProducts() {
  try {
    const products = await ApiService.fetchProducts("featured")
    renderProducts(products, "featured-products")
  } catch (error) {
    console.error("Error loading featured products:", error)
  }
}

async function loadRecentProducts() {
  try {
    const products = await ApiService.fetchProducts("recent")
    renderProducts(products, "recent-products")
  } catch (error) {
    console.error("Error loading recent products:", error)
  }
}

function renderProducts(products, containerId) {
  const container = document.getElementById(containerId)
  if (!container) return
  container.innerHTML = ""

  products.forEach(product => {
    // Safely convert price and original_price to numbers
    const price = Number(product.price) || 0
    const originalPrice = Number(product.original_price) || null

    const productHtml = `
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <div class="product-item bg-light mb-4">
          <div class="product-img position-relative overflow-hidden">
            <img class="img-fluid w-100" src="${product.image_path || "img/default-product.jpg"}" alt="${product.name}" />
            <div class="product-action">
              <a class="btn btn-outline-dark btn-square" href="#shop"><i class="fa fa-shopping-cart"></i></a>
              <a class="btn btn-outline-dark btn-square" href="#home"><i class="fa fa-sync-alt"></i></a>
            </div>
          </div>
          <div class="text-center py-4">
            <a class="h6 text-decoration-none text-truncate" href="#detailed_product/${product.id}">${product.name}</a>
            <div class="d-flex align-items-center justify-content-center mb-1">
              ${renderRating(product.rating)}
              <small>(${product.review_count || 0})</small>
            </div>
          </div>
        </div>
      </div>
    `
    container.insertAdjacentHTML("beforeend", productHtml)
  })
}

function renderRating(rating) {
  rating = rating || 0
  let starsHtml = ""
  const fullStars = Math.floor(rating)
  const hasHalfStar = rating % 1 >= 0.5

  for (let i = 0; i < fullStars; i++) {
    starsHtml += '<small class="fa fa-star text-primary mr-1"></small>'
  }

  if (hasHalfStar) {
    starsHtml += '<small class="fa fa-star-half-alt text-primary mr-1"></small>'
  }

  const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0)
  for (let i = 0; i < emptyStars; i++) {
    starsHtml += '<small class="far fa-star text-primary mr-1"></small>'
  }

  return starsHtml
}

async function loadProductDetail(productId) {
  console.log("Loading product with ID:", productId)

  try {
    const product = await ApiService.fetchProduct(productId)
    console.log("Fetched product:", product)

    $("#productImage").attr("src", product.image_path || "img/default-product.jpg")
    $("#productName").text(product.name || "No name")
    $("#productPrice").text(`$${Number(product.price).toFixed(2)}`)
    $("#productDescription").text(product.description || "")
    $("#reviews").text(`(${product.review_count || 0} Reviews)`)

    $("#longDescription").text(product.long_description || product.description || "")

    if (typeof renderRating === "function") {
      $(".product-rating").html(renderRating(product.rating))
    }
  } catch (error) {
    $("#productName").text("Product not found")
    $("#productDescription").text("")
    $("#productPrice").text("")
    $("#productImage").attr("src", "img/default-product.jpg")
    $("#reviews").text("")
    $("#longDescription").text("")
    $(".text-primary.mr-2").html("")
  }
}
window.loadProductDetail = loadProductDetail

//ALL MY SHOP LOGIC

let shopProducts = []
let shopCurrentPage = 1
let shopProductsPerPage = 9

async function loadShopProducts() {
  try {
    // Fetch all products for the shop
    shopProducts = await ApiService.fetchProducts()
    renderShopProducts()
    renderShopPagination()
  } catch (error) {
    console.error("Error loading shop products:", error)
    $("#shop-products").html("<div class='col-12 text-center'>Failed to load products.</div>")
  }
}

function renderShopProducts() {
  const container = document.getElementById("shop-products")
  if (!container) return
  container.innerHTML = ""

  // Filter products by active price filters
  let filteredProducts = shopProducts.filter(product => {
    const price = Number(product.price) || 0
    return activePriceFilters.some(filter => price >= filter.min && price < filter.max)
  })

  // Pagination logic
  const start = (shopCurrentPage - 1) * shopProductsPerPage
  const end = start + shopProductsPerPage
  const productsToShow = filteredProducts.slice(start, end)

  productsToShow.forEach(product => {
    const price = Number(product.price) || 0
    const originalPrice = Number(product.original_price) || null
    const productHtml = `
      <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
        <div class="product-item bg-light mb-4">
          <div class="product-img position-relative overflow-hidden">
            <img class="img-fluid w-100" src="${product.image_path || "img/default-product.jpg"}" alt="${product.name}" />
            <div class="product-action">
              <a class="btn btn-outline-dark btn-square" href="#shopping_cart"><i class="fa fa-shopping-cart"></i></a>
              <a class="btn btn-outline-dark btn-square" href="#shop"><i class="fa fa-sync-alt"></i></a>
            </div>
          </div>
          <div class="text-center py-4">
            <a class="h6 text-decoration-none text-truncate" href="#detailed_product/${product.id}">${product.name}</a>
            <div class="d-flex align-items-center justify-content-center mb-1">
              ${renderRating(product.rating)}
              <small>(${product.review_count || 0})</small>
            </div>
            <div class="d-flex align-items-center justify-content-center mt-2">
              <h5>$${price.toFixed(2)}</h5>
              ${originalPrice ? `<h6 class="text-muted ml-2"><del>$${originalPrice.toFixed(2)}</del></h6>` : ""}
            </div>
          </div>
        </div>
      </div>
    `
    container.insertAdjacentHTML("beforeend", productHtml)
  })
  renderShopPagination(filteredProducts.length)
}

function renderShopPagination(filteredCount = null) {
  const totalProducts = filteredCount !== null ? filteredCount : shopProducts.length
  const totalPages = Math.ceil(totalProducts / shopProductsPerPage)
  const pagination = document.getElementById("shop-pagination")
  if (!pagination) return
  pagination.innerHTML = ""

  for (let i = 1; i <= totalPages; i++) {
    pagination.innerHTML += `
      <li class="page-item ${i === shopCurrentPage ? "active" : ""}">
        <a class="page-link shop-page-link" href="#">${i}</a>
      </li>
    `
  }
}

// Event listeners for pagination and show count
$(document).on("click", ".shop-page-link", function (e) {
  e.preventDefault()
  shopCurrentPage = Number($(this).text())
  renderShopProducts()
  renderShopPagination()
})

$(document).on("click", ".show-count", function (e) {
  e.preventDefault()
  shopProductsPerPage = Number($(this).data("count"))
  shopCurrentPage = 1
  renderShopProducts()
  renderShopPagination()
})

window.loadShopProducts = loadShopProducts

//Adding my Filetering logic trying to have it actually work

let activePriceFilters = [{ min: 0, max: 10000 }]

$(document).on("change", ".price-filter", function () {
  if (this.id === "price-all" && this.checked) {
    $(".price-filter").not(this).prop("checked", false)
  } else if (this.id !== "price-all" && this.checked) {
    $("#price-all").prop("checked", false)
  }
  if ($(".price-filter:checked").length === 0) {
    $("#price-all").prop("checked", true)
  }
  updateActivePriceFilters()
  renderShopProducts()
})

function updateActivePriceFilters() {
  activePriceFilters = []
  $(".price-filter:checked").each(function () {
    activePriceFilters.push({
      min: Number($(this).data("min")),
      max: Number($(this).data("max"))
    })
  })
  if (activePriceFilters.length === 0) {
    activePriceFilters = [{ min: 0, max: 10000 }]
  }
}

//Adding my Shopping Cart logic

function getCartKey() {
  const user = JSON.parse(localStorage.getItem("user"))
  return user ? `cart_${user.id}` : "cart_guest"
}

function getCart() {
  return JSON.parse(localStorage.getItem(getCartKey()) || "[]")
}
function setCart(cart) {
  localStorage.setItem(getCartKey(), JSON.stringify(cart))
  updateCartBadge()
}

window.getCart = getCart
window.setCart = setCart
window.renderCheckout = renderCheckout

//Trying to make sure only logged in users can access the cart and adding to cart in general

$(document).on("click", "#addToCartBtn", async function () {
  const user = JSON.parse(localStorage.getItem("user"))
  if (!user) {
    alert("You must be logged in to add items to your cart.")
    return
  }
  const productId = window.location.hash.split("/")[1]
  if (!productId) return

  try {
    const product = await ApiService.fetchProduct(productId)
    let cart = getCart()
    const existing = cart.find(item => item.id == product.id)
    if (existing) {
      existing.quantity += 1
    } else {
      cart.push({
        id: product.id,
        name: product.name,
        price: Number(product.price),
        image_path: product.image_path,
        quantity: 1
      })
    }
    setCart(cart)
    alert("Added to cart!")
  } catch (e) {
    alert("Failed to add to cart.")
  }
})

function renderCart() {
  const cart = getCart()
  const container = document.getElementById("cart-items")
  if (!container) return

  if (cart.length === 0) {
    container.innerHTML = `<tr><td colspan="5" class="text-center">Your cart is empty.</td></tr>`
    $(".cart-summary-subtotal").text("$0")
    $(".cart-summary-total").text("$0")
    return
  }

  let subtotal = 0
  container.innerHTML = ""
  cart.forEach(item => {
    const total = item.price * item.quantity
    subtotal += total
    container.innerHTML += `
      <tr>
        <td class="align-middle"><img src="${item.image_path || "img/default-product.jpg"}" alt="" style="width: 50px" /> ${item.name}</td>
        <td class="align-middle">$${item.price.toFixed(2)}</td>
        <td class="align-middle">
          <div class="input-group quantity mx-auto" style="width: 100px">
            <div class="input-group-btn">
              <button class="btn btn-sm btn-primary btn-minus" data-id="${item.id}"><i class="fa fa-minus"></i></button>
            </div>
            <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="${item.quantity}" readonly />
            <div class="input-group-btn">
              <button class="btn btn-sm btn-primary btn-plus" data-id="${item.id}"><i class="fa fa-plus"></i></button>
            </div>
          </div>
        </td>
        <td class="align-middle">$${total.toFixed(2)}</td>
        <td class="align-middle">
          <button class="btn btn-sm btn-danger btn-remove" data-id="${item.id}"><i class="fa fa-times"></i></button>
        </td>
      </tr>
    `
  })
  $(".cart-summary-subtotal").text(`$${subtotal.toFixed(2)}`)
  const shipping = cart.length > 0 ? 10 : 0
  $(".cart-summary-total").text(`$${(subtotal + shipping).toFixed(2)}`)
}

// Quantity and remove handlers
$(document).on("click", ".btn-plus", function () {
  const id = $(this).data("id")
  let cart = getCart()
  const item = cart.find(i => i.id == id)
  if (item) item.quantity += 1
  setCart(cart)
  renderCart()
})
$(document).on("click", ".btn-minus", function () {
  const id = $(this).data("id")
  let cart = getCart()
  const item = cart.find(i => i.id == id)
  if (item && item.quantity > 1) item.quantity -= 1
  setCart(cart)
  renderCart()
})
$(document).on("click", ".btn-remove", function () {
  const id = $(this).data("id")
  let cart = getCart().filter(i => i.id != id)
  setCart(cart)
  renderCart()
})

$(document).on("spapp:afterViewLoad", function (e, view) {
  if (view === "shopping_cart") renderCart()
})

window.renderCart = renderCart

// Adding a little Checkout logic

function renderCheckout() {
  const cart = getCart()
  const productsContainer = document.getElementById("checkout-products")
  const subtotalElem = document.getElementById("checkout-subtotal")
  const shippingElem = document.getElementById("checkout-shipping")
  const totalElem = document.getElementById("checkout-total")

  if (!productsContainer || !subtotalElem || !shippingElem || !totalElem) return

  let subtotal = 0
  productsContainer.innerHTML = ""

  if (cart.length === 0) {
    productsContainer.innerHTML = `<div class="text-center text-muted">Your cart is empty.</div>`
    subtotalElem.textContent = "$0"
    shippingElem.textContent = "$0"
    totalElem.textContent = "$0"
    return
  }

  cart.forEach(item => {
    const total = item.price * item.quantity
    subtotal += total
    productsContainer.innerHTML += `
      <div class="d-flex justify-content-between">
        <p>${item.name} x${item.quantity}</p>
        <p>$${total.toFixed(2)}</p>
      </div>
    `
  })

  const shipping = cart.length > 0 ? 10 : 0
  subtotalElem.textContent = `$${subtotal.toFixed(2)}`
  shippingElem.textContent = `$${shipping.toFixed(2)}`
  totalElem.textContent = `$${(subtotal + shipping).toFixed(2)}`

  updateCartBadge()
}

function updateCartBadge() {
  const cart = getCart()
  const count = cart.reduce((sum, item) => sum + item.quantity, 0)
  $("a[href='#shopping_cart'] .badge").text(count)
}

window.loadAdminProducts = loadAdminProducts
window.renderAdminProductList = renderAdminProductList

//Admin Panel Logic

// Fetch all products and render in the admin table
async function loadAdminProducts() {
  try {
    const products = await ApiService.fetchProducts()
    renderAdminProductList(products)
  } catch (error) {
    alert("Failed to load products: " + error.message)
  }
}

function renderAdminProductList(products) {
  const tbody = document.getElementById("productList")
  if (!tbody) return
  tbody.innerHTML = ""
  products.forEach(product => {
    tbody.innerHTML += `
      <tr>
        <td>${product.name}</td>
        <td>${product.description || ""}</td>
        <td>$${Number(product.price).toFixed(2)}</td>
        <td>
          <button class="btn btn-sm btn-warning edit-product" data-id="${product.id}">Edit</button>
          <button class="btn btn-sm btn-danger delete-product" data-id="${product.id}">Delete</button>
        </td>
      </tr>
    `
  })
}
//Adding product
$(document).on("submit", "#addListingForm", async function (e) {
  e.preventDefault()

  const name = $("#productName").val()
  const price = Number($("#productPrice").val())
  const description = $("#productDescription").val()
  const stock = Number($("#productStock").val())

  try {
    await ApiService.authFetch("/products", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        name,
        price,
        description,
        stock
      })
    })
    alert("Product added!")
    loadAdminProducts()
    this.reset()
  } catch (err) {
    alert("Failed to add product: " + err.message)
  }
})

//Delition logic
$(document).on("click", ".delete-product", async function () {
  if (!confirm("Are you sure you want to delete this product?")) return
  const id = $(this).data("id")
  try {
    await ApiService.authFetch(`/products/${id}`, { method: "DELETE" })
    alert("Product deleted!")
    loadAdminProducts()
  } catch (err) {
    alert("Failed to delete product: " + err.message)
  }
})

$(document).on("click", ".edit-product", async function () {
  const id = $(this).data("id")
  try {
    const product = await ApiService.fetchProduct(id)

    $("#editProductId").val(product.id)
    $("#editProductName").val(product.name)
    $("#editProductPrice").val(product.price)
    $("#editProductStock").val(product.stock_quantity || product.stock || 0)
    $("#editProductDescription").val(product.description)

    $("#editProductModal").modal("show")
  } catch (err) {
    alert("Failed to load product for editing: " + err.message)
  }
})

// Edit form submit handler
$(document).on("submit", "#editProductForm", async function (e) {
  e.preventDefault()
  const id = $("#editProductId").val()
  const name = $("#editProductName").val()
  const price = Number($("#editProductPrice").val())
  const stock = Number($("#editProductStock").val())
  const description = $("#editProductDescription").val()

  try {
    await ApiService.authFetch(`/products/${id}`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ name, price, stock, description })
    })
    alert("Product updated!")
    $("#editProductModal").modal("hide")
    loadAdminProducts()
  } catch (err) {
    alert("Failed to update product: " + err.message)
  }
})
