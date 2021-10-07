<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Календарь компании</title>
    <style>
        td {
            position: relative;
        }

        td a {
            display: block;
            text-align: center;
            width: 92.5px;
            height: 22px;
        }

        table {
            text-align: center;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
<div class="container">
    <div class="row">
        <div class="input-group mt-5">
            <a href="/" class="btn btn-primary" aria-current="page">Календарь компании</a>
            <a href="/worker" class="btn btn-primary active">Календарь сотрудника</a>
        </div>
        <div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item">
                        <a class="page-link" href="/worker/{{ date("Y-m-d", strtotime("-1 week", $currentDate)) }}"
                           aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="/worker/{{ date("Y-m-d", $currentDate + 60*60*24*7) }}"
                           aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Сотрудник
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href=""></a></li>
                            <li><a class="dropdown-item" href=""></a></li>
                            <li><a class="dropdown-item" href=""></a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th scope="col"></th>
                    @for ($i = 0; $i<=6; $i++)
                        <th scope="col">{{ date("d.m.Y", $currentDate + $i*60*60*24) }}</th>
                    @endfor
                </tr>
                </thead>
                <tbody>
                <?php
                $hours = array(
                    0 => "10:00",
                    1 => "10:15",
                    2 => "10:30",
                    3 => "10:45",
                    4 => "11:00",
                    5 => "11:15",
                    6 => "11:30",
                    7 => "11:45",
                    8 => "12:00",
                    9 => "12:15",
                    10 => "12:30",
                    11 => "12:45",
                    12 => "13:00",
                    13 => "13:15",
                    14 => "13:30",
                    15 => "13:45",
                    16 => "14:00",
                    17 => "14:15",
                    18 => "14:30",
                    19 => "14:45",
                    20 => "15:00",
                    21 => "15:15",
                    22 => "15:30",
                    23 => "15:45",
                    24 => "16:00",
                    25 => "16:15",
                    26 => "16:30",
                    27 => "16:45",
                    28 => "17:00",
                    29 => "17:15",
                    30 => "17:30",
                    31 => "17:45",
                    32 => "18:00",
                    33 => "18:15",
                    34 => "18:30",
                    35 => "18:45",
                    36 => "19:00"
                );
                $idWorker = 1;
                foreach ($hours as $hour){
                ?>
                <tr>
                    <th scope="row"><?=$hour?></th>
                    <?php
                    for ($td = 0; $td < 7; $td++){
                    ?>
                    <td><a href="" id="<?= $idWorker?>"></a></td>
                    <? $idWorker++;} ?>
                </tr>
                <?php  } ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-3">
            <form>
                <div class="row">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Дата</label>
                        <input type="date" class="form-control" id="exampleFormControlInput1">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Повторить событие</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected></option>
                            <option value="1">Не повторять</option>
                            <option value="2">Ежедневно</option>
                            <option value="3">Еженедельно</option>
                            <option value="4">Ежемесячно</option>
                            <option value="5">Будние дни</option>
                            <option value="6">Период</option>
                        </select>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Время старт</label>
                            <input type="time" class="form-control" id="exampleFormControlInput1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Дата старт</label>
                            <input type="date" class="form-control" id="exampleFormControlInput1">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Время окончание</label>
                            <input type="time" class="form-control" id="exampleFormControlInput1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Дата окончание</label>
                            <input type="date" class="form-control" id="exampleFormControlInput1">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Описание textarea</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>

                    <button type="button" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
</html>
