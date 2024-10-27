document.addEventListener("DOMContentLoaded", function() {
    var c = document.getElementById('c');
    var ctx = c.getContext('2d');
    var sidebar = document.querySelector('.sidebar');

    // Set the canvas to fit the sidebar
    c.width = sidebar.clientWidth;
    c.height = sidebar.clientHeight;

    // Hebrew characters array
    var heb = 'אבגדהוזחטיכלמנסעפצקרשת'.split('');
    var font_size = 15;
    var columns = c.width / font_size; // Number of columns for rain
    var drops = Array.from({ length: columns }, () => 1); // Initialize drops

    function draw() {
        ctx.fillStyle = 'rgba(0, 0, 0, 0.05)'; // Background trail
        ctx.fillRect(0, 0, c.width, c.height);

        ctx.fillStyle = '#87CEEB'; // Blue text color
        ctx.font = font_size + 'px arial';

        // Loop over drops for rain effect
        for (let i = 0; i < drops.length; i++) {
            let text = heb[Math.floor(Math.random() * heb.length)];
            ctx.fillText(text, i * font_size, drops[i] * font_size);

            // Reset drop to top randomly
            if (drops[i] * font_size > c.height && Math.random() > 0.975) {
                drops[i] = 0;
            }

            // Move drop down
            drops[i]++;
        }
    }

    setInterval(draw, 33); // Draw at 33ms intervals
});
