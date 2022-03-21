<table class="w-full leading-normal gad-table">
    <thead>
        <tr>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Coordinator
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Implement Year
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Status
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Created At
            </th>
            @hasrole('Admin')
                <th scope="col"
                    class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                    Actions
                </th>
            @endhasrole
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script type="text/javascript">
    $(function () {
        var columns = [
            {
                data: 'user',
                name: 'user'
            },
            {
                data: 'implement_year',
                name: 'implement_year'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },    
        ];

        if('{{ auth()->user()->hasRole("Admin")}}') {
            columns.push({
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            });
        }

        var table = $('.gad-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('gadplans.index') }}",
            columns: columns
        });

    });

</script>
