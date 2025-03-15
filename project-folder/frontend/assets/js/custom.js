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
      initPageFunctions()
    }
  })

  app.route({
    view: "shop",
    load: "shop.html",
    onReady: function () {
      $("section").hide()
      $("#shop").show()
    }
  })

  app.route({
    view: "shopping_cart",
    load: "shopping_cart.html",
    onReady: function () {
      $("section").hide()
      $("#shopping_cart").show()
    }
  })

  app.route({
    view: "detailed_product",
    load: "detailed_product.html",
    onReady: function () {
      $("section").hide()
      $("#detailed_product").show()
    }
  })

  app.route({
    view: "contact",
    load: "contact.html",
    onReady: function () {
      $("section").hide()
      $("#contact").show()
    }
  })

  app.route({
    view: "checkout",
    load: "checkout.html",
    onReady: function () {
      $("section").hide()
      $("#checkout").show()
    }
  })

  app.run()
})
