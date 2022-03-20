<table class="min-w-full leading-normal" id="manage-users-table">
    <thead>
        <tr>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Name
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Role
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<script type="text/javascript">
    $(function () {

        var table = $('#manage-users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('manage-users.index') }}",
            columns: [
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });

        $("#manage-users-table").on('click', '.del-btn[data-remote]', function (e) {
            e.preventDefault();

            var url = $(this).data('remote');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'manage-users/' + url,
                type: 'DELETE',
                dataType: 'json',
                data: {
                    method: '_DELETE',
                    submit: true
                }
            }).always(function (data) {
                $('.campus-table').DataTable().draw(false);
            });
        });

    });

</script>
