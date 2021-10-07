<h1>Просмотр календаря</h1>

<p><a href="/calendar/{{ date("Y-m-d", strtotime("-1 week", $currentDate)) }}">Влево</a> – {{ date("d.m.Y", $currentDate) }} {{ $currentDate }} – <a href="/calendar/{{ date("Y-m-d", $currentDate + 60*60*24*7) }}">Вправо</a></p>


<table>
    <tr>
        <th></th>
        @for ($i = 0; $i<=6; $i++)
            <th>{{ date("d.m.Y", $currentDate + $i*60*60*24) }}</th>
        @endfor

    </tr>
</table>