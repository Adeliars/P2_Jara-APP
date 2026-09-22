<!DOCTYPE html>
<html>
<head>
    <title>Tambah Anggota Project</title>
</head>

<body>

<h1>Tambah Anggota Project</h1>


<form action="/project/{{ $project->id }}/member" method="POST">

    @csrf

    <label>Pilih Anggota:</label>

    <select name="user_id">

        @foreach($users as $user)

            <option value="{{ $user->id }}">
                {{ $user->name }}
            </option>

        @endforeach

    </select>


    <button type="submit">
        Tambah Anggota
    </button>

</form>


</body>
</html>