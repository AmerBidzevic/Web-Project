;(function ($) {
  "use strict"

  // Dropdown on mouse hover
  $(document).ready(function () {
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
    toggleNavbarMethod()
    $(window).resize(toggleNavbarMethod)
  })

  // Back to top button
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      $(".back-to-top").fadeIn("slow")
    } else {
      $(".back-to-top").fadeOut("slow")
    }
  })
  $(".back-to-top").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo")
    return false
  })

  // Vendor carousel
  $(".vendor-carousel").owlCarousel({
    loop: true,
    margin: 29,
    nav: false,
    autoplay: true,
    smartSpeed: 1000,
    responsive: {
      0: {
        items: 2
      },
      576: {
        items: 3
      },
      768: {
        items: 4
      },
      992: {
        items: 5
      },
      1200: {
        items: 6
      }
    }
  })

  // Related carousel
  $(".related-carousel").owlCarousel({
    loop: true,
    margin: 29,
    nav: false,
    autoplay: true,
    smartSpeed: 1000,
    responsive: {
      0: {
        items: 1
      },
      576: {
        items: 2
      },
      768: {
        items: 3
      },
      992: {
        items: 4
      }
    }
  })

  // Product Quantity
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
})(jQuery)

//Modal code
$(document).ready(function () {
  // When the Login button is clicked
  $("#login-btn").click(function () {
    $(".modal-title").text("Login")

    $("#login-form").show()
    $("#signup-form").hide()

    $("#toggle-form").text("Don't have an account? Sign Up")
    $("#toggle-to-login").hide()
    $("#myModal").modal("show")
  })

  // When the Sign Up button is clicked
  $("#sign_up-btn").click(function () {
    $(".modal-title").text("Sign Up")

    $("#signup-form").show()
    $("#login-form").hide()

    $("#toggle-form").text("Already a member? Login")
    $("#toggle-to-login").show()

    $("#myModal").modal("show")
  })

  // Toggle between Login and Sign Up forms
  $("#toggle-form").click(function () {
    if ($(".modal-title").text() === "Sign Up") {
      $(".modal-title").text("Login")
      $("#login-form").show()
      $("#signup-form").hide()

      // Update toggle text to "Don't have an account? Sign Up"
      $("#toggle-form").text("Don't have an account? Sign Up")
      $("#toggle-to-login").hide()
    } else {
      // Show the Sign Up form and hide the Login form
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

    // Update toggle text to "Don't have an account? Sign Up"
    $("#toggle-form").text("Don't have an account? Sign Up")
    $("#toggle-to-login").hide()
  })
})
//Product Details LOGIC
