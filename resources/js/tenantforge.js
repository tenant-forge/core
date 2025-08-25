import intersect from '@alpinejs/intersect'

Alpine.plugin(intersect)

function isDark() {
    return (
        localStorage.theme === 'dark' ||
        ((!'theme') in localStorage &&
            window.matchMedia('(prefers-color-scheme: dark)').matches)
    )
}

document.documentElement.classList.toggle('dark', isDark())

Alpine.store('theme', {
    init() {
        document.documentElement.classList.toggle('dark', isDark())
        this.dark = isDark()
    },
    dark: isDark(),
    darkTheme() {
        this.dark = true
        localStorage.theme = 'dark'
        document.documentElement.classList.add('dark')
    },
    lightTheme() {
        this.dark = false
        localStorage.theme = 'light'
        document.documentElement.classList.remove('dark')
    },
})
