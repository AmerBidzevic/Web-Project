(function ($) {
  "use strict";

  // Dropdown on mouse hover
  $(document).ready(function () {
    function toggleNavbarMethod() {
      if ($(window).width() > 992) {
        $(".navbar .dropdown")
          .on("mouseover", function () {
            $(".dropdown-toggle", this).trigger("click");
          })
          .on("mouseout", function () {
            $(".dropdown-toggle", this).trigger("click").blur();
          });
      } else {
        $(".navbar .dropdown").off("mouseover").off("mouseout");
      }
    }
    toggleNavbarMethod();
    $(window).resize(toggleNavbarMethod);
  });

  // Back to top button
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      $(".back-to-top").fadeIn("slow");
    } else {
      $(".back-to-top").fadeOut("slow");
    }
  });
  $(".back-to-top").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo");
    return false;
  });

  // Vendor carousel
  $(".vendor-carousel").owlCarousel({
    loop: true,
    margin: 29,
    nav: false,
    autoplay: true,
    smartSpeed: 1000,
    responsive: {
      0: {
        items: 2,
      },
      576: {
        items: 3,
      },
      768: {
        items: 4,
      },
      992: {
        items: 5,
      },
      1200: {
        items: 6,
      },
    },
  });

  // Related carousel
  $(".related-carousel").owlCarousel({
    loop: true,
    margin: 29,
    nav: false,
    autoplay: true,
    smartSpeed: 1000,
    responsive: {
      0: {
        items: 1,
      },
      576: {
        items: 2,
      },
      768: {
        items: 3,
      },
      992: {
        items: 4,
      },
    },
  });

  // Product Quantity
  $(document).on("click", ".quantity button", function () {
    var button = $(this);
    var oldValue = button.closest(".quantity").find("input").val();

    if (button.hasClass("btn-plus")) {
      var newVal = parseFloat(oldValue) + 1;
    } else {
      if (oldValue > 0) {
        var newVal = parseFloat(oldValue) - 1;
      } else {
        newVal = 0;
      }
    }

    button.closest(".quantity").find("input").val(newVal);
  });
})(jQuery);

//Modal code
$(document).ready(function () {
  $("#login-btn").click(function () {
    $(".modal-title").text("Login");

    $("#login-form").show();
    $("#signup-form").hide();

    $("#toggle-form").text("Don't have an account? Sign Up");
    $("#toggle-to-login").hide();
    $("#myModal").modal("show");
  });

  $("#sign_up-btn").click(function () {
    $(".modal-title").text("Sign Up");

    $("#signup-form").show();
    $("#login-form").hide();

    $("#toggle-form").text("Already a member? Login");
    $("#toggle-to-login").show();

    $("#myModal").modal("show");
  });

  // Toggle between Login and Sign Up forms
  $("#toggle-form").click(function () {
    if ($(".modal-title").text() === "Sign Up") {
      $(".modal-title").text("Login");
      $("#login-form").show();
      $("#signup-form").hide();

      $("#toggle-form").text("Don't have an account? Sign Up");
      $("#toggle-to-login").hide();
    } else {
      $(".modal-title").text("Sign Up");
      $("#signup-form").show();
      $("#login-form").hide();

      $("#toggle-form").text("Already a member? Login");
      $("#toggle-to-login").show();
    }
  });

  $("#toggle-to-login").click(function () {
    $(".modal-title").text("Login");
    $("#login-form").show();
    $("#signup-form").hide();

    $("#toggle-form").text("Don't have an account? Sign Up");
    $("#toggle-to-login").hide();
  });
});

//Correct navigation JS

$(document).ready(function () {
  function updateActiveNav() {
    var currentView = window.location.hash || "#home";

    $(".nav-item").removeClass("active");

    if (currentView === "#home") {
      $('.nav-link[href="#home"]').addClass("active");
    } else if (currentView === "#shop") {
      $('.nav-link[href="#shop"]').addClass("active");
    } else if (currentView === "#contact") {
      $('.nav-link[href="#contact"]').addClass("active");
    } else if (currentView === "#shopping_cart") {
      $('.nav-link[href="#shopping_cart"]').addClass("active");
    }
  }

  updateActiveNav();

  $(window).on("hashchange", function () {
    updateActiveNav();
  });
});

//End of navigation JS

// Admin panel add logic

$(document).ready(function () {
  $(document).on("submit", "#addListingForm", function (e) {
    e.preventDefault();

    var name = $("#productName").val();
    var price = $("#productPrice").val();
    var description = $("#productDescription").val();
    var additionalInfo = $("#productAdditionalInfo").val();
    var status = $("#productStatus").val();
    var imageInput = $("#productImage")[0];

    if (imageInput.files.length === 0) {
      alert("Please select an image.");
      return;
    }

    var productImage = URL.createObjectURL(imageInput.files[0]);

    var newRow = `<tr class="product-row" data-status="${status}">
      <td><img src="${productImage}" alt="Product Image" width="50"></td>
      <td>${name}</td>
      <td>${description}</td>
      <td>${additionalInfo}</td>
      <td>${price}</td>
      <td class="status">${status}</td>
      <td>
        <button class="btn btn-warning btn-sm toggle-status" id="toggle-status-btn">Toggle Status</button>
        <button class="btn btn-danger btn-sm delete-listing" id="delete-listing-btn">Delete</button>
      </td>
    </tr>`;

    $("#productList").append(newRow);

    $("#addListingForm")[0].reset();
  });

  $(document).on("click", ".toggle-status", function () {
    var statusCell = $(this).closest("tr").find(".status");
    var currentStatus = statusCell.text();
    var newStatus = currentStatus === "Active" ? "Inactive" : "Active";
    statusCell.text(newStatus);

    $(this).closest("tr").attr("data-status", newStatus);
  });

  $(document).on("click", ".delete-listing", function () {
    $(this).closest("tr").remove();
  });
});
