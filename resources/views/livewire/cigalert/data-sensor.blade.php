<div>

    <div id="tabelcigalert"></div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
        setInterval(function() {
            fetch("{{route('tabelcigalert')}}")
                .then(response => response.text())
                .then(html => {
                    document.getElementById("tabelcigalert").innerHTML = html;
                })
                .catch(error => console.error('Error loading content:', error));
        }, 1000);
    });
</script>
</div>
