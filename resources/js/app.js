import './bootstrap';

document.addEventListener('livewire:navigated', () => {
    window.HSStaticMethods.autoInit();
})
