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
                        <a class="page-link"
                           href="/worker/{{$idCalendar}}/{{ date("Y-m-d", strtotime("-1 week", $currentDate)) }}"
                           aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link"
                           href="/worker/{{$idCalendar}}/{{ date("Y-m-d", $currentDate + 60*60*24*7) }}"
                           aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <form method="POST" action="/worker/select">
                    @csrf
                    <div class="row">
                        <div class="col-sm">
                            <select name="calendar" class="form-control">
{{--                                <option value="null">Сотрудник</option>--}}
                                @foreach($workers as $worker)
                                <option value="{{$worker['id']}}" {{$worker['id'] == $idCalendar ? 'selected' : ''}}>{{$worker['name']}}</option>
                                @endforeach
{{--                                <option value="2">Александр Петро</option>--}}
{{--                                <option value="3">Данила Козловский</option>--}}
                            </select>
                        </div>
                    </div>
                    <br>
                    <button type="submit" name="submit" class="btn btn-primary">Перейти</button>
                </form>
            </nav>
            @include('calendar.calendar-ui')
        </div>
        <div class="col-lg-3">
            <form method="post" action="/create">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Дата</label>
                        <input type="date" class="form-control" id="exampleFormControlInput1" name="currentDate">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Повторить событие</label>
                        <select class="form-select" aria-label="Default select example" name="retryEvent">
                            <option selected></option>
                            <option value="not">Не повторять</option>
                            <option value="everyday">Ежедневно</option>
                            <option value="everyweek">Еженедельно</option>
                            <option value="everymonth">Ежемесячно</option>
                            <option value="weekdays">Будние дни</option>
                            <option value="period">Период</option>
                        </select>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Время старт</label>
                            <input type="time" class="form-control" id="exampleFormControlInput1" name="time_start">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Дата старт</label>
                            <input type="date" class="form-control" id="exampleFormControlInput1" name="date_start">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Время окончание</label>
                            <input type="time" class="form-control" id="exampleFormControlInput1" name="time_finish">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Дата окончание</label>
                            <input type="date" class="form-control" id="exampleFormControlInput1" name="date_finish">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Описание textarea</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                  name="title"></textarea>
                    </div>
                    <input type="hidden" name="idCalendarUser" value="{{$idCalendar}}">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
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
