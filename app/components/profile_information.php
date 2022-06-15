<div class="card block">
  <div class="card-image">
    <figure class="image">
      <img src="/getimage?name=<?php echo $userinfo['profile_image'] ?>" alt="Profile Picture">
    </figure>
  </div>
  <div class="card-content">
    <div class="media">
      <div class="media-left">
        <figure class="image is-48x48">
          <img src="/getimage?name=<?php echo $userinfo['profile_image'] ?>" alt="Profile Picture Small">
        </figure>
      </div>
      <div class="media-content">
        <p class="title is-4"><?php echo $userinfo['name'] ?></p>
        <p class="subtitle is-6">@<?php echo $userinfo['username'] ?></p>
      </div>
    </div>

    <div class="content">
      <div class="title is-5">Biography</div>
      <div>

        <?php
        if (isset($userinfo['biography']))
          echo $userinfo['biography'];
        else
          echo 'No biography information';
        ?>
      </div>
    </div>
  </div>
</div>