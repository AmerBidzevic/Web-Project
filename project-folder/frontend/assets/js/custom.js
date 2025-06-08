$(document).ready(function () {
  var app = $.spapp({
    defaultView: "home",
    templateDir: "./tpl/",
    pageNotFound: "error_404"
  })

  app.route({
    view: "home",
    load: "home.html",
    onReady: function () {
      $("section").hide()
      $("#home").show()
      window.scrollTo(0, 0) //I put this on each of them so when it loads the page it goes to the top on the new loaded page
      if (window.loadFeaturedProducts) window.loadFeaturedProducts()
      if (window.loadRecentProducts) window.loadRecentProducts()
    }
  })

  app.route({
    view: "shop",
    load: "shop.html",
    onReady: function () {
      $("section").hide()
      $("#shop").show()
      window.scrollTo(0, 0)
      if (window.loadShopProducts) window.loadShopProducts()
    }
  })

  app.route({
    view: "shopping_cart",
    load: "shopping_cart.html",
    onReady: function () {
      $("section").hide()
      $("#shopping_cart").show()
      window.scrollTo(0, 0)
      if (window.renderCart) window.renderCart()
    }
  })

  app.route({
    view: "detailed_product",
    load: "detailed_product.html",
    default: false,
    onReady: function (params) {
      $("section").hide()
      $("#detailed_product").show()
      window.scrollTo(0, 0)
      let productId = params && params[0]
      if (!productId) {
        const hash = window.location.hash
        productId = hash.split("/")[1]
      }
      console.log("Product ID in onReady:", productId)
      if (typeof loadProductDetail === "function") {
        loadProductDetail(productId)
      } else if (window.loadProductDetail) {
        window.loadProductDetail(productId)
      } else {
        console.log("loadProductDetail is not defined")
      }
    },
    route: /^detailed_product\/(\d+)$/
  })
  app.route({
    view: "contact",
    load: "contact.html",
    onReady: function () {
      $("section").hide()
      $("#contact").show()
      window.scrollTo(0, 0)
    }
  })
  app.route({
    view: "admin_panel",
    load: "admin_panel.html",
    onReady: function () {
      $("section").hide()
      $("#admin_panel").show()
      window.scrollTo(0, 0)
      if (window.loadAdminProducts) window.loadAdminProducts()
    }
  })

  app.route({
    view: "checkout",
    load: "checkout.html",
    onReady: function () {
      $("section").hide()
      $("#checkout").show()
      window.scrollTo(0, 0)
      if (window.renderCheckout) window.renderCheckout()
    }
  })

  app.run()
})
