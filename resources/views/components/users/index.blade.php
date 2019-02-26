<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Birth Date</th>
            <th>Address</th>
            <th>Contact</th>
            <th>Username</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Birth Date</th>
            <th>Address</th>
            <th>Contact</th>
            <th>Username</th>
        </tr>
        </tfoot>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->firstname }}</td>
                <td>{{ $user->middlename }}</td>
                <td>{{ $user->lastname }}</td>
                <td>{{ ucfirst($user->gender) }}</td>
                <td>{{ Carbon\Carbon::parse($user->birthdate)->format('M j, Y') }}</td>
                <td>{{ $user->address }}</td>
                <td>{{ $user->contact }}</td>
                <td>{{ $user->username }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>