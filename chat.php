<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
          $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{
            header("location: users.php");
          }
        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="php/images/<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
          <p><?php echo $row['status']; ?></p>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button class="fileOpen" onclick="openPopup()"><i class="fas fa-regular fa-folder-open"></i></button>
        <button class="send"><i class="fab fa-telegram-plane"></i></button>
        <div class="popup" id="popup">
          <span class="close" onclick="closePopup()">&times;</span>
          <h3>Share File</h3>
          <div class="file-input-wrapper" onclick="handleIconClick()">
            <i id="fileIcon" class="fas fa-file"></i>
            <input type="file" id="fileInput" style="display: none;" onchange="handleFileChange()">
            <i id="fileIcon" class="fas fa-image"></i>
            <input type="file" id="fileInput" accept=".jpg, .jpeg, .png" style="display: none;" onchange="handleFileChange()">
          </div>
          <!-- <button onclick="closePopup()">Close</button> -->
      </div>
      </form>
    </section>
  </div>

  <script>// Function to open the popup
function openPopup() {
  document.getElementById("popup").style.display = "block";
}

// Function to close the popup
function closePopup() {
  document.getElementById("popup").style.display = "none";
}

// Close the popup if the popup is clicked
document.getElementById("popup").addEventListener("click", function (event) {
  if (event.target === document.getElementById("popup")) {
    closePopup();
  }
});
function handleIconClick() {
    document.getElementById('fileInput').click();
  }

  function handleFileChange() {
    // Handle file change event if needed
    // For example, you can display the selected file name
    var fileName = document.getElementById('fileInput').value.split('\\').pop();
    alert('Selected file: ' + fileName);
  }
</script>
  <script src="javascript/chat.js"></script>

</body>
</html>
