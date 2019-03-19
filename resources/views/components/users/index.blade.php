@php
use Illuminate\Support\Facades\Auth;
@endphp

<div class="table-responsive">
    <table class="table table-bordered" id="user-dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>Action</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Gender</th>
            <th>Birth Date</th>
            <th>Address</th>
            <th>Contact</th>
            <th>Username</th>
            @if (Auth::user()->is_teacher)
                <th>Section</th>
            @endif
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Action</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Gender</th>
            <th>Birth Date</th>
            <th>Address</th>
            <th>Contact</th>
            <th>Username</th>
            @if (Auth::user()->is_teacher)
                <th>Section</th>
            @endif
        </tr>
        </tfoot>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>
                  <a class="nav-link p-0  text-right" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="  false">
                    Action
                  </a>
                  <div class="dropdown-menu">
                    @if (Auth::user()->is_teacher)
                      <a href="{{ route('students.show', ['student' => $user->id]) }}" class="p-2">View</a><br>
                    @elseif (Auth::user()->is_admin)
                      <a href="{{ route('teachers.edit', ['teacher' => $user->id]) }}" class="p-2">Edit</a>
                      <form action="{{ route('teachers.destroy', ['teacher' => $user->id]) }}" method="POST"
                        onsubmit="return confirm('Are you sure?')">
                          @csrf
                          @method('DELETE')
                        <a href="#" class="p-2" onclick="$(this).closest('form').submit()">
                          Delete
                        </a>
                      </form>
                    @endif
                  </div>
                </td>
                <td>{{ $user->lastname }}</td>
                <td>{{ $user->firstname }}</td>
                <td>{{ $user->middlename }}</td>
                <td>{{ ucfirst($user->gender) }}</td>
                <td>{{ Carbon\Carbon::parse($user->birthdate)->format('M j, Y') }}</td>
                <td>{{ $user->address }}</td>
                <td>{{ $user->contact }}</td>
                <td>{{ $user->username }}</td>
                @if (Auth::user()->is_teacher)
                    <td>{{ $user->section }}</td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@push('scripts')

<script type="text/javascript">
  
  $('#user-dataTable').dataTable( {
        dom: 'Bfrtip',
        buttons: [
          'pdf',
        ]
    } );
</script>


@endpush