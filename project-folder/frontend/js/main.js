(function ($) {
  "use strict";

  // Dropdown on mouse hover
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

  // Back to top button
  function backToTopHandler() {
    if ($(window).scrollTop() > 100) {
      $(".back-to-top").fadeIn("slow");
    } else {
      $(".back-to-top").fadeOut("slow");
    }
  }

  // Update active navigation link based on hash
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

  function updateAuthUI() {
    const token = localStorage.getItem("jwt_token");
    const user = JSON.parse(localStorage.getItem("user"));

    console.log("Current user:", user);

    if (token && user) {
      $("#login-btn").hide();
      $("#sign_up-btn").hide();
      $("#user-profile").text(user.email).show();
      $("#logout-button").show();

      console.log("User role:", user.role);
      console.log("Admin link element:", $("#admin-link").length);

      if (user.role === "admin") {
        console.log("Showing admin link");
        $("#admin-link").show();
      } else {
        console.log("Hiding admin link");
        $("#admin-link").hide();
      }
    } else {
      console.log("User not logged in - resetting UI");
      $("#login-btn").show();
      $("#sign_up-btn").show();
      $("#user-profile").hide();
      $("#logout-button").hide();
      $("#admin-link").hide();
    }
  }
  async function authFetch(url, options = {}) {
    const token = localStorage.getItem("jwt_token");
    if (!token) {
      window.location.href = "#home";
      return;
    }

    const headers = {
      "Content-Type": "application/json",
      Authorization: token,
      ...options.headers,
    };

    try {
      const response = await fetch(url, {
        ...options,
        headers,
      });

      if (response.status === 401) {
        localStorage.removeItem("jwt_token");
        localStorage.removeItem("user");
        updateAuthUI();
        window.location.href = "#home";
        return;
      }

      return response;
    } catch (error) {
      console.error("Request failed:", error);
      throw error;
    }
  }

  $(document).ready(function () {
    // Init dropdown hover method and window resize
    toggleNavbarMethod();
    $(window).resize(toggleNavbarMethod);

    // Back to top button scroll event
    $(window).scroll(backToTopHandler);
    backToTopHandler();

    // Back to top button click
    $(".back-to-top").click(function () {
      $("html, body").animate({ scrollTop: 0 }, 1500, "swing");
      return false;
    });

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
        1200: { items: 6 },
      },
    });

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
        992: { items: 4 },
      },
    });

    // Product quantity buttons
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

    updateAuthUI();

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

    $(document).on("submit", "#actual-login-form", async function (e) {
      e.preventDefault();
      const email = $("#email").val();
      const password = $("#psw").val();

      try {
        const response = await fetch("http://localhost/AmerBidzevic/Web-Project/project-folder/backend/auth/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ email, password }),
        });

        const text = await response.text();

        if (!response.ok) {
          console.error("Server error:", text);
          if (response.headers.get("content-type")?.includes("application/json")) {
            try {
              const errorData = JSON.parse(text);
              alert(errorData.error || "Login failed");
            } catch {
              alert("Login failed. Server error.");
            }
          } else {
            alert("Login failed. Please check your connection and try again.");
          }
          return;
        }

        let data;
        try {
          data = JSON.parse(text);
          console.log("Login response data:", data);
        } catch (parseError) {
          console.error("Invalid JSON from server:", text);
          alert("Login failed. Invalid response from server.");
          return;
        }

        if (data.message && data.message.toLowerCase().includes("successful")) {
          localStorage.setItem("jwt_token", data.data.token);
          localStorage.setItem("user", JSON.stringify(data.data.user));

          updateAuthUI();

          $("#myModal").modal("hide");
          $(".modal-backdrop").remove();
          $("body").removeClass("modal-open");

          window.location.href = "#home";
        } else {
          alert(data.error || data.message || "Login failed");
        }
      } catch (error) {
        alert("Login failed. Please check your connection and try again.");
      }
    });

    $(document).on("submit", "#actual-signup-form", async function (e) {
      e.preventDefault();
      const email = $("#new-email").val();
      const username = $("#new-username").val();
      const password = $("#new-psw").val();

      try {
        const response = await fetch("http://localhost/AmerBidzevic/Web-Project/project-folder/backend/auth/register", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ username, email, password }),
        });

        const text = await response.text();
        let data;

        try {
          data = JSON.parse(text);
        } catch (parseError) {
          alert("Registration failed. Invalid response from server.");
          return;
        }

        if (response.ok) {
          alert("Registration successful! Please login.");
          $(".modal-title").text("Login");
          $("#login-form").show();
          $("#signup-form").hide();
          $("#toggle-form").text("Don't have an account? Sign Up");
          $("#toggle-to-login").hide();
        } else {
          alert(data.error || data.message || "Registration failed");
        }
      } catch (error) {
        alert("Registration failed. Please check your connection and try again.");
      }
    });

    $("#logout-button").click(function () {
      localStorage.removeItem("jwt_token");
      localStorage.removeItem("user");
      updateAuthUI();
      window.location.href = "#home";
    });

    updateActiveNav();

    $(window).on("hashchange", updateActiveNav);
  });
})(jQuery);
