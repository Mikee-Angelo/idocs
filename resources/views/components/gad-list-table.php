<table class="w-32 leading-normal gad-list-table">
    <thead>
        <tr>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Gender Issue and/or GAD Mandate
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Cause of the Gender Issue
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                GAD result statement/GAD Objective
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Relevant Agencies
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                GAD Activity
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Output Performace Indicator and Target
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Budgetary Requirement
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Source of Budget
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Responsible Unit
            </th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<script type="text/javascript">
    $(function () {

        var table = $('.gad-list-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'items',
            scrollX: "100%",
            
            columns: [{
                    data: 'gad_issue_mandate',
                    name: 'gad_issue_mandate'
                },
                {
                    data: 'cause_of_issue',
                    name: 'cause_of_issue'
                },
                {
                    data: 'gad_statement_objective',
                    name: 'gad_statement_objective'
                },
                {
                    data: 'relevant_agencies',
                    name: 'relevant_agencies'
                },
                {
                    data: 'gad_activity',
                    name: 'gad_activity'
                },
                {
                    data: 'indicator_target',
                    name: 'indicator_target'
                },
                {
                    data: 'budget_requirement',
                    name: 'budget_requirement'
                },
                {
                    data: 'budget_source',
                    name: 'budget_source'
                },
                {
                    data: 'responsible_unit',
                    name: 'responsible_unit'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });

        $(".gad-list-table").on('click', '.del-btn[data-remote]', function (e) {
            e.preventDefault();

            var url = $(this).data('remote');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'gadplans/1/lists' + url,
                type: 'DELETE',
                dataType: 'json',
                data: {
                    method: '_DELETE',
                    submit: true
                }
            }).always(function (data) {
                $('.gad-list-table').DataTable().draw(false);
            });
        });

    });

</script>
