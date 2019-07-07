<?php

// Настройки поделючения к БД
$host = "127.0.0.1"; // Адрес хоста (обычно localhost)
$login = "trinity"; // Логин от БД
$pass = "trinity"; // Пароль от БД
$name = "characters"; // Имя БД персонажей (обычно characters)

// Настройки функционала

$count_killers = 10; // Какое количество игроков выводить в "Топ убийц". По умолчанию 10
$count_honor = 10; // Какое количество игроков выводить в "Топ хонора". По умолчанию 10
$count_2х2 = 10; // Какое количество игроков выводить в "Топ 2х2". По умолчанию 10
$count_3х3 = 10; // Какое количество игроков выводить в "Топ 3х3". По умолчанию 10
$count_5х5 = 10; // Какое количество игроков выводить в "Топ 5х5". По умолчанию 10


?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Топ игроки сервера</title>
  <link rel="stylesheet" href="css/main.min.css">
  <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
</head>

<body>
  <main class="legend">
    <div class="legend__wrap">
      <aside class="legend__aside">
        <h1 class="legend__title">Топ игроков сервера</h1>
        <nav class="legend__nav">
          <ul class="legend__menu">
            <li class="legend__menu-item">
              <button data-type="kill" class="btn legend__menu-btn">Топ убийц</button>
            </li>
            <li class="legend__menu-item">
              <button data-type="honor" class="btn legend__menu-btn">Топ хонора</button>
            </li>
            <li class="legend__menu-item">
              <button data-type="arena2" class="btn legend__menu-btn">Топ арены 2х2</button>
            </li>
            <li class="legend__menu-item">
              <button data-type="arena3" class="btn legend__menu-btn">Топ арены 3х3</button>
            </li>
            <li class="legend__menu-item">
              <button data-type="arena5" class="btn legend__menu-btn">Топ арены 5х5</button>
            </li>
          </ul>
        </nav>
        <button class="btn legend__back" onclick="window.history.back();">Вернуться назад</button>
        <div class="legend__aside-img">
          <img src="img/race.png" class="legend__aside-img" alt="Лучшие игроки сервера" title="Лучшие игроки сервера">
        </div>
      </aside>
      <section class="legend__section">
        <h2 class="legend__subtitle"><span></span></h2>
        <?php

        $connect = new mysqli($host, $login, $pass, $name);
        $connect->query("SET NAMES `utf8` COLLATE `utf8_general_ci`");

        if ($connect->connect_error) {
          echo "Ошибка подключения к базе данных";
        } else {
          $sql = "SELECT `name`, `race`, `totalKills` FROM `characters` ORDER BY `totalKills` DESC LIMIT $count_killers";
          $res = $connect->query($sql);
          $i = 0; ?>
          <ul class="legend__list active" data-type="kill">

            <?php while ($data = $res->fetch_assoc()) {
              $i++;
              $name = $data["name"];
              $race = $data["race"];
              $kill = $data["totalKills"];
              if ($race == "1" || $race == "3" || $race == "4" || $race == "7" || $race == "11") {
                $race_src = "img/alliance.png";
              } else {
                $race_src = "img/horde.png";
              } ?>

              <li class="legend__item">
                <p class="legend__item-wrap">
                  <span class="legend__item-span legend__item-span--num"><?= $i ?></span>
                  <span class="legend__item-span legend__item-span--race"><img src="<?= $race_src ?>" alt="Расса"></span>
                  <span class="legend__item-span legend__item-span--name"><?= $name ?></span>
                  <span class="legend__item-span legend__item-span--scope"><b><?= $kill ?></b> кил.</span>
                </p>
              </li>

            <?php  }  ?>

          </ul>

          <?php
          $sql = "SELECT `name`, `race`, `totalHonorPoints` FROM `characters` ORDER BY `totalHonorPoints` DESC LIMIT $count_honor";
          $res = $connect->query($sql);
          $i = 0; ?>

          <ul class="legend__list active" data-type="honor">

            <?php while ($data = $res->fetch_assoc()) {
              $i++;
              $name = $data["name"];
              $race = $data["race"];
              $kill = $data["totalHonorPoints"];
              if ($race == "1" || $race == "3" || $race == "4" || $race == "7" || $race == "11") {
                $race_src = "img/alliance.png";
              } else {
                $race_src = "img/horde.png";
              } ?>

              <li class="legend__item">
                <p class="legend__item-wrap">
                  <span class="legend__item-span legend__item-span--num"><?= $i ?></span>
                  <span class="legend__item-span legend__item-span--race"><img src="<?= $race_src ?>" alt="Расса"></span>
                  <span class="legend__item-span legend__item-span--name"><?= $name ?></span>
                  <span class="legend__item-span legend__item-span--scope"><b><?= $kill ?></b> хон.</span>
                </p>
              </li>

            <?php  }  ?>

          </ul>

          <?php
          $sql = "SELECT `name`, `rating` FROM `arena_team` WHERE `type` = 2  ORDER BY `rating` DESC LIMIT $count_2х2";
          $res = $connect->query($sql);
          $i = 0; ?>

          <ul class="legend__list active" data-type="arena2">

            <?php while ($data = $res->fetch_assoc()) {
              $i++;
              $name = $data["name"];
              $kill = $data["rating"]; ?>

              <li class="legend__item">
                <p class="legend__item-wrap">
                  <span class="legend__item-span legend__item-span--num"><?= $i ?></span>
                  <span class="legend__item-span legend__item-span--name"><?= $name ?></span>
                  <span class="legend__item-span legend__item-span--scope"><b><?= $kill ?></b> рейт.</span>
                </p>
              </li>

            <?php  }  ?>

          </ul>

          <?php
          $sql = "SELECT `name`, `rating` FROM `arena_team` WHERE `type` = 3 ORDER BY `rating` DESC LIMIT $count_3х3";
          $res = $connect->query($sql);
          $i = 0; ?>

          <ul class="legend__list active" data-type="arena3">

            <?php while ($data = $res->fetch_assoc()) {
              $i++;
              $name = $data["name"];
              $kill = $data["rating"]; ?>

              <li class="legend__item">
                <p class="legend__item-wrap">
                  <span class="legend__item-span legend__item-span--num"><?= $i ?></span>
                  <span class="legend__item-span legend__item-span--name"><?= $name ?></span>
                  <span class="legend__item-span legend__item-span--scope"><b><?= $kill ?></b> рейт.</span>
                </p>
              </li>

            <?php  }  ?>

          </ul>

          <?php
          $sql = "SELECT `name`, `rating` FROM `arena_team` WHERE `type` = 5 ORDER BY `rating` DESC LIMIT $count_5х5";
          $res = $connect->query($sql);
          $i = 0; ?>

          <ul class="legend__list active" data-type="arena5">

            <?php while ($data = $res->fetch_assoc()) {
              $i++;
              $name = $data["name"];
              $kill = $data["rating"]; ?>

              <li class="legend__item">
                <p class="legend__item-wrap">
                  <span class="legend__item-span legend__item-span--num"><?= $i ?></span>
                  <span class="legend__item-span legend__item-span--name"><?= $name ?></span>
                  <span class="legend__item-span legend__item-span--scope"><b><?= $kill ?></b> рейт.</span>
                </p>
              </li>

            <?php  }  ?>
          </ul>

        <?php } ?>

      </section>
    </div>
  </main>
  <script src="js/scripts.min.js"></script>
</body>

</html>