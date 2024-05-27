import './bootstrap';

document.addEventListener('livewire:navigated', () => {
    window.HSStaticMethods.autoInit();
})

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('calc').addEventListener('click', function(event) {
        if (event.target.classList.contains('show-footer')) {
            var footer = document.getElementById('footer');
            if (footer.classList.contains('show')) {
                footer.classList.remove('show');
                setTimeout(function() {
                    footer.classList.add('d-none');
                }, 500);
            } else {
                footer.classList.remove('d-none');
                setTimeout(function() {
                    footer.classList.add('show');
                }, 10);
            }
        }
    });
});
document.getElementById('sweet_btn').onclick = function() {
    Swal.fire({
        title: "<span style='color:gold;'>GOOD FOOD</span>",
        text: "ဝယ်ယူမှုအတွက်ကျေးဇူးတင်ပါသည်။",
        icon: "success",
        iconColor: "gold",
        confirmButtonText: "<span style='color:black;'>Thank You!</span>",
        confirmButtonColor: "gold",
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = "index.html";
        }
    });
}
