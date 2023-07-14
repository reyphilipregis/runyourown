@extends('layouts.app')

@section('content')

<div>
    <h3>Bill Invoices List</h3>

    <div class="alert alert-info" role="alert">
        <b>1C.</b> The system needs to display a field to select a month. Upon selection, display a list of bill invoice numbers which end in that month.
        <br /><br />
        <h5>Assumptions:</h5>
        <p>Based on my understanding of the instruction, I will <b>ONLY</b> display the invoice number column based on month and year.</p>
        <br />
        <h5>Note:</h5>
        <p>Although it may not be explicitly mentioned in the instructions, including the <b>Year</b> dropdown provides a more comprehensive and logical selection for the bill invoices. By including the year dropdown, you ensure that the selected month corresponds to the desired year's bill invoices. This approach avoids any confusion or mismatches between the selected month and bill invoices from different years. Including both the month and year dropdowns allows for more accurate and specific filtering of the bill invoices, enhancing the user experience and overall usability of the system.</p>
    </div>

    <form>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="month">Month</label>
                    <select class="form-control" id="month" name="month">
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="year">Year</label>
                    <select class="form-control" id="year" name="year">
                        @php
                            $currentYear = date('Y');
                            for ($i = $currentYear; $i > $currentYear - 5; $i--) {
                                echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                        @endphp
                    </select>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <div class="bill-result">
        <table class="table table-striped" id="billTable" style="display: none;">
            <thead>
                <tr>
                    <th>Invoice Number</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <p id="noRecordsFound" class="text-danger" style="display: none;">No records found.</p>
    </div>
</div>

<script>
    // Get the base URL from the Laravel .env file
    var baseUrl = '{{ env('APP_URL') }}';

    // Handle form submission
    $('form').submit(function(e) {
        e.preventDefault();

        var month = $('#month').val();
        var year = $('#year').val();

        // Make an AJAX call to the API route
        $.ajax({
            url: baseUrl + '/api/bills/' + month + '/' + year,
            type: 'GET',
            success: function(response) {
                // If the API call is successful, display the results in the table
                var invoices = response;

                // Clear the table body
                $('#billTable tbody').empty();

                if (invoices.length > 0) {
                    // Loop through the invoices and append rows to the table
                    $.each(invoices, function(index, invoice) {
                        var row = '<tr>' +
                            '<td>' + invoice + '</td>' +
                            '</tr>';
                        $('#billTable tbody').append(row);
                    });

                    // Show the table
                    $('#billTable').show();
                    $('#noRecordsFound').hide();
                } else {
                    // No records found
                    $('#billTable').hide();
                    $('#noRecordsFound').show();
                }
            },
            error: function() {
                alert('An error occurred while fetching the bill invoices.');
            }
        });
    });
</script>

@endsection
