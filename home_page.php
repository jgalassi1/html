<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <meta charset="utf-8">
    <title>
        Iron Manor
    </title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="navbar">
        <button type="button" class="btn-logo">
            <img src="Screen Shot 2023-04-27 at 2.04.07 AM.png" alt="homejpg" width=45px; height=40px; />
        </button>
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#postModal">
            Post
        </button>
        <a href="explore_wp.php">
            <button type="button" class="btn btn-warning">
                Explore Workout Plans
            </button>
        </a>
        <a href="explore_mp.php">
            <button type="button" class="btn btn-warning">
                Explore Meal Plans
            </button>
        </a>
        <a href="/">
            <button type="button" class="btn btn-outline-warning">
                Logout
            </button>
        </a>
    </div>
</head>
<hr>
<hr>
<hr>

<body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9gybBud5t2c5zR7BbNfBTNg5IOE0CMeswvz6BQgduX3M6fCo3p9" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <?php session_start();
    $user = $_SESSION['user']; ?>
    <img src="Screen Shot 2023-04-27 at 2.05.37 AM.png" alt="welcomejpg" class="welcome" />
    <hr>
    <h1>
        Welcome to the House of Gainz,
        <?php echo $user; ?>
    </h1>
    <div class="columns-container">
        <div class="left-column">
            <h2>Feed</h2> <br>
            <?php include('feed.php'); ?>
        </div>
        <div class="center-column">
            <h2>Lifts</h2> <br>
            <?php include('display_workouts.php'); ?>
        </div>
        <div class="right-column">
            <h2>Fuel</h2>
            <?php include('display_meals.php'); ?>
        </div>
    </div>

    <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postModalLabel">Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea id="postText" class="form-control" rows="3"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" id="submitPost">Post</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#submitPost').on('click', function() {
            var user = "<?php echo $user; ?>";
            const postText = $('#postText').val();
            $.ajax({
                type: 'POST',
                url: 'process_post.php',
                data: {
                    text: postText,
                    user: user
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', textStatus, errorThrown);
                }
            });
            $('#postModal').modal('hide');
            $('#postText').val('');
        });
    });
    </script>

</body>

</html>