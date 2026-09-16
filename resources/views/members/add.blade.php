<!DOCTYPE html>
<html>
    <head>
        <title>Add Member</title>
    </head>
    <body>
        <h1>Add Member to Project</h1>
        <form method="POST" action="/members">
        @csrf

        <label for="email">Member Email:</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Add Member</button>
        </form>
    </body>

</html>