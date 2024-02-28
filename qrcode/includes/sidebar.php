<input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>N<span>UST</span></h3>
        </div>
        
        <div class="side-content">
            <div class="profile">
                <div class="profile-img bg-img" style="background-image: url(img/3.jpeg)"></div>
                <h4>David Green</h4>
                <small>Examiner</small>
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                       <a href="index.php">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                       <a href="exams.php">
                        <span class="material-icons-sharp">receipt_long</span>
                            <small>Exams</small>
                        </a>
                    </li>
                    <li>
                       <a href="examentry.php">
                        <span class="material-symbols-sharp">qr_code_scanner</span>
                            <small>Exam Entry</small>
                        </a>
                    </li>
                    <li>
                       <a href="examexit.php">
                        <span class="material-symbols-sharp">signature</span>
                            <small>Exam Exit</small>
                        </a>
                    </li>
                    <li>
                       <a href="#">
                        <span class="las la-user-alt"></span>
                            <small>Students</small>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <script>
    // Get all <a> elements
var links = document.querySelectorAll('.side-menu a');

// Loop through the links
for (var i = 0; i < links.length; i++) {
    // Check if the link's href attribute matches the current URL
    if (links[i].href == window.location.href) {
        // Add the 'active' class
        links[i].classList.add('active');
    }
}
</script>