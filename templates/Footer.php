</div>
<footer class="footer bottom">
    <div class="bg-light" style="height: 5rem">

    </div>
</footer>
</body>
<script src="/js/jquery.datetimepicker.full.js"></script>
<script src="/js/jquery.fine-uploader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
<?php
if (empty($_SESSION['user_id']))
    exit("<meta http-equiv='refresh' content='0; url=http://tisbi-lms.ru/index.php'>");
$sql->close();