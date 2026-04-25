const mobileToggle = document.getElementById('mobileToggle')
const navLinks = document.getElementById('navLinks')
const showMoreBtn = document.getElementById('showMoreBtn')
const hiddenModules = document.querySelectorAll('.hidden-module')
const navbar = document.getElementById('navbar')
const themeToggle = document.getElementById('themeToggle')
const registrationRoot = document.querySelector('[data-registration-type]')
const registrationType = registrationRoot?.dataset?.registrationType
const candidateFields = document.querySelectorAll('[data-role="candidate-fields"]')
const companyFields = document.querySelectorAll('[data-role="company-fields"]')
const cardLinks = document.querySelectorAll('[data-card-link]')
const profilePhotoInput = document.getElementById('profilePhotoInput')
const profilePhotoPreview = document.getElementById('profilePhotoPreview')
const profilePhotoFallback = document.getElementById('profilePhotoFallback')

if (themeToggle) {
    themeToggle.addEventListener('click', () => {
        const currentTheme = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light'
        const nextTheme = currentTheme === 'dark' ? 'light' : 'dark'

        document.documentElement.setAttribute('data-theme', nextTheme)
        localStorage.setItem('managerahub-theme', nextTheme)
    })
}

if (mobileToggle && navLinks) {
    mobileToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active')
    })
}

if (showMoreBtn) {
    let expanded = false

    showMoreBtn.addEventListener('click', () => {
        expanded = !expanded

        hiddenModules.forEach(module => {
            module.style.display = expanded ? 'block' : 'none'
        })

        showMoreBtn.textContent = expanded ? 'Show Less' : 'Show More'
    })
}

window.addEventListener('scroll', () => {
    if (navbar && window.scrollY > 50) {
        navbar.classList.add('scrolled')
    } else if (navbar) {
        navbar.classList.remove('scrolled')
    }
})

if (registrationType) {
    const isCandidate = registrationType === 'candidate'

    candidateFields.forEach(field => {
        field.hidden = !isCandidate
    })

    companyFields.forEach(field => {
        field.hidden = isCandidate
    })
}

cardLinks.forEach(card => {
    card.addEventListener('click', event => {
        const href = card.getAttribute('href')

        if (!href) {
            return
        }

        const target = event.target
        if (target instanceof HTMLElement && target.closest('a') === card) {
            window.location.href = href
        }
    })
})

if (profilePhotoInput && profilePhotoPreview && profilePhotoFallback) {
    profilePhotoInput.addEventListener('change', () => {
        const [file] = profilePhotoInput.files ?? []

        if (!file) {
            profilePhotoPreview.style.display = 'none'
            profilePhotoPreview.removeAttribute('src')
            profilePhotoFallback.style.display = 'grid'
            return
        }

        const reader = new FileReader()

        reader.addEventListener('load', () => {
            profilePhotoPreview.src = String(reader.result)
            profilePhotoPreview.style.display = 'block'
            profilePhotoFallback.style.display = 'none'
        })

        reader.readAsDataURL(file)
    })
}
