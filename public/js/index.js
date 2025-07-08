document.addEventListener("DOMContentLoaded", () => {
  // --- SIDEBAR DESKTOP (chevron uniquement) ---
  const sidebar = document.getElementById("sidebar");
  const sidebarToggle = document.getElementById("sidebarToggle");

  if (sidebar && sidebarToggle) {
    sidebarToggle.addEventListener("click", () => {
      sidebar.classList.toggle("sidebar-closed");
      sidebar.classList.toggle("sidebar-open");
    });
  }

  // --- MENU BURGER (MOBILE) ---
  const burger = document.getElementById("burgerBtn");
  const menu = document.getElementById("navLinks");

  function isMobile() {
    return window.innerWidth < 900;
  }

  if (burger && menu) {
    burger.addEventListener("click", (e) => {
      if (!isMobile()) return;
      e.stopPropagation();
      menu.classList.toggle("active");
      burger.classList.toggle("active");
    });

    document.addEventListener("click", (e) => {
      if (!isMobile()) return;
      if (!menu.contains(e.target) && !burger.contains(e.target)) {
        menu.classList.remove("active");
        burger.classList.remove("active");
      }
    });

    window.addEventListener("scroll", () => {
      if (!isMobile()) return;
      menu.classList.remove("active");
      burger.classList.remove("active");
    });
  }

  // --- FORMULAIRE DE CONTACT ---
  const contactForm = document.querySelector("#contact form");
  if (contactForm) {
    contactForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const submitBtn = contactForm.querySelector('button[type="submit"]');
      const originalText = submitBtn.textContent;

      try {
        submitBtn.textContent = "Envoi en cours...";
        submitBtn.disabled = true;

        const response = await fetch(contactForm.action, {
          method: "POST",
          body: new FormData(contactForm),
          headers: { Accept: "application/json" },
        });

        if (response.ok) {
          alert("Message envoyé avec succès !");
          contactForm.reset();
        } else {
          throw new Error("Erreur lors de l'envoi");
        }
      } catch (error) {
        alert("Une erreur est survenue, veuillez réessayer.");
        console.error(error);
      } finally {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
      }
    });
  }

  // --- ANNÉE DYNAMIQUE ---
  const yearSpan = document.getElementById("year");
  if (yearSpan) {
    yearSpan.textContent = new Date().getFullYear();
  }

  // --- HEADER SCROLL (uniquement pour mobile) ---
  const header = document.querySelector(".musician-header");
  let lastScrollY = window.scrollY;

  window.addEventListener("scroll", () => {
    const currentScrollY = window.scrollY;

    if (currentScrollY > 80) {
      header.classList.add("scrolled");
    } else {
      header.classList.remove("scrolled");
    }

    if (
      currentScrollY > lastScrollY &&
      currentScrollY > 100 &&
      window.innerWidth < 900
    ) {
      header.classList.add("hide");
    } else {
      header.classList.remove("hide");
    }

    lastScrollY = currentScrollY;
  });

  // --- ANIMATION APPARITION DES SECTIONS ---
  const sections = document.querySelectorAll(".section-appear");
  const observer = new window.IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
        } else {
          entry.target.classList.remove("visible");
        }
      });
    },
    {
      threshold: 0.2,
    }
  );
  sections.forEach((section) => observer.observe(section));

  // --- MODALE DE CONNEXION ADMIN ---
  const loginLink = document.getElementById("admin-login-link");
  const modal = document.getElementById("admin-login-modal");
  const closeBtn = document.getElementById("close-login-modal");

  if (loginLink && modal && closeBtn) {
    loginLink.addEventListener("click", function (e) {
      e.preventDefault();
      modal.classList.add("show");
    });

    closeBtn.addEventListener("click", function () {
      modal.classList.remove("show");
    });

    window.addEventListener("click", function (event) {
      if (event.target === modal) {
        modal.classList.remove("show");
      }
    });

    window.addEventListener("keydown", function (event) {
      if (event.key === "Escape") {
        modal.classList.remove("show");
      }
    });
  }

  // --- ERREUR LOGIN (disparaît après 5s) ---
  const errorDiv = document.getElementById("login-error");
  if (errorDiv && errorDiv.textContent.trim() !== "") {
    setTimeout(() => {
      errorDiv.textContent = "";
    }, 5000);
  }

  // --- FLIP CARD ---
  document.querySelectorAll(".flip-card").forEach((card) => {
    card.addEventListener("click", function () {
      this.classList.toggle("flipped");
    });
  });

  // --- DETAILS BIO ---
  const summary = document.querySelector(".see-more-dropdown > summary");
  const details = document.querySelector(".see-more-dropdown");
  const target = document.getElementById("bio-details");

  if (summary && details && target) {
    summary.addEventListener("click", function (e) {
      setTimeout(() => {
        if (details.open) {
          target.scrollIntoView({ behavior: "smooth", block: "start" });
        }
      }, 50);
    });
  }
});

// --- FONCTIONS GLOBALES (hors DOMContentLoaded) ---
window.toggleConcertsSection = function () {
  const section = document.getElementById("concerts-section");
  const btn = document.getElementById("concerts-toggle-btn");
  const arrow = document.getElementById("concerts-arrow");
  const isOpen = section.style.display === "block";
  section.style.display = isOpen ? "none" : "block";
  if (btn) btn.setAttribute("aria-expanded", !isOpen);
  if (arrow) arrow.classList.toggle("open", !isOpen);
};

window.toggleEditForm = function (id, cancel = false) {
  document
    .querySelectorAll(".edit-concert-form")
    .forEach((form) => (form.style.display = "none"));
  if (!cancel) {
    const form = document.getElementById("editForm-" + id);
    if (form) {
      form.style.display = "block";
    }
  }
};
