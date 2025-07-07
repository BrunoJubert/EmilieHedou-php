document.addEventListener("DOMContentLoaded", () => {
  // --- MENU BURGER ---
  const burger = document.getElementById("burgerBtn");
  const menu = document.getElementById("navLinks");

  if (burger && menu) {
    burger.addEventListener("click", (e) => {
      e.stopPropagation();
      menu.classList.toggle("active");
      burger.classList.toggle("active");
    });

    document.addEventListener("click", (e) => {
      if (!menu.contains(e.target) && !burger.contains(e.target)) {
        menu.classList.remove("active");
        burger.classList.remove("active");
      }
    });

    window.addEventListener("scroll", () => {
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

  // --- HEADER SCROLL ---
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
});

  // --- CONNEXION ---

document.addEventListener("DOMContentLoaded", function () {
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
});

document.addEventListener("DOMContentLoaded", () => {
  const errorDiv = document.getElementById("login-error");
  if (errorDiv && errorDiv.textContent.trim() !== "") {
    setTimeout(() => {
      errorDiv.textContent = "";
    }, 5000); 
  }
});

function toggleConcertsSection() {
  const section = document.getElementById("concerts-section");
  section.style.display = section.style.display === "block" ? "none" : "block";
}


function toggleEditForm(id, closeOnly) {
  const form = document.getElementById("editForm-" + id);
  if (closeOnly) {
    form.style.display = "none";
  } else {
    form.style.display = form.style.display === "block" ? "none" : "block";
  }
}

function toggleConcertsSection() {
  const section = document.getElementById("concerts-section");
  const btn = document.getElementById("concerts-toggle-btn");
  const arrow = document.getElementById("concerts-arrow");
  const isOpen = section.style.display === "block";
  section.style.display = isOpen ? "none" : "block";
  btn.setAttribute("aria-expanded", !isOpen);
  arrow.classList.toggle("open", !isOpen);
}


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

document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".flip-card").forEach((card) => {
    card.addEventListener("click", function () {
      this.classList.toggle("flipped");
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const summary = document.querySelector(".see-more-dropdown > summary");
  const details = document.querySelector(".see-more-dropdown");
  const target = document.getElementById("bio-details");

  if (summary && details && target) {
    summary.addEventListener("click", function (e) {
      // On laisse le comportement natif ouvrir le details
      setTimeout(() => {
        if (details.open) {
          target.scrollIntoView({ behavior: "smooth", block: "start" });
        }
      }, 50); // petit délai pour laisser le <details> s’ouvrir
    });
  }
});


document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.getElementById("sidebar");
  const sidebarToggle = document.getElementById("sidebarToggle");

  if (sidebar && sidebarToggle) {
    sidebarToggle.addEventListener("click", () => {
      sidebar.classList.toggle("sidebar-closed");
      sidebar.classList.toggle("sidebar-open");
    });
  }
});






