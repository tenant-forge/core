import intersect from '@alpinejs/intersect'

Alpine.plugin(intersect)

window.darkTheme = () => {
    window.theme = 'dark'
    localStorage.theme = 'dark'
    document.documentElement.classList.add('dark')
}

window.lightTheme = () => {
    window.theme = 'light'
    localStorage.theme = 'light'
    document.documentElement.classList.remove('dark')
}
