@extends('layouts.app')

@section('content')

<div>
    <h3>Site Detail View</h3>

    <div class="alert alert-info" role="alert">
        <b>1D.</b> The system needs to display details for any given site. The site details should include the name, address, and an average yearly total amount ($) calculated using the bill data for the site.
    </div>

    <div class="table-responsive">
        <form>
            <div class="form-group">
                <label for="siteId">Site ID</label>
                <input type="text" class="form-control" id="siteId" name="siteId" value="{{ $details['id'] }}" readonly>
            </div>
            <div class="form-group">
                <label for="siteName">Name</label>
                <input type="text" class="form-control" id="siteName" name="siteName" value="{{ $details['name'] }}" readonly>
            </div>
            <div class="form-group">
                <label for="siteAddress">Address</label>
                <input type="text" class="form-control" id="siteAddress" name="siteAddress" value="{{ $details['address'] }}" readonly>
            </div>
            <div class="form-group">
                <label for="averageAmount">Average Yearly Amount</label>
                <input type="text" class="form-control" id="averageAmount" name="averageAmount" value="${{ number_format($details['yearly_average_amount'], 2) }}" readonly>
            </div>

            <br />

            <div class="alert alert-info" role="alert">
                <b>1F.</b> The system should include a graph for a given site that displays the total amount ($) of each bill for the site in an appropriate format.
                <br /><br />
                <b>Note:</b>
                <p>From what I undertsnad I need to create a graph for all bills of the site with their corresponding amount. So I formatted the y-axis to Bill-{$billId}.</p>
            </div>

            <div class="form-group">
                <label>Bill Graph</label>
                <div id="billGraph"></div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('additional-scripts')
<script>
    // Fetch the chart data from API
    fetch('{{ config("app.api_url") }}/api/sites/{{ $details["id"] }}/bills')
        .then(response => response.json())
        .then(data => {
            // Transform the data for Highcharts
            var billData = data;

            // Parse the amount to float
            billData.forEach(item => {
                item[1] = parseFloat(item[1]);
            });
            
            // Render the bar chart
            Highcharts.chart('billGraph', {
                chart: {
                    type: 'bar',
                    height: 800 // Set the height of the chart
                },
                title: {
                    text: 'Amount ($) of Each Bill',
                    style: {
                        fontSize: '14px'
                    }
                },
                xAxis: {
                    type: 'category',
                    title: {
                        text: 'Bills'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Amount ($)'
                    },
                    labels: {
                        formatter: function () {
                            return '$' + Highcharts.numberFormat(this.value, 0, '.', ','); // Format the value with a comma for thousands
                        }
                    }
                },
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.series.name + '</b><br>' +
                            '$' + Highcharts.numberFormat(this.point.y, 0, '.', ','); // Format the value with a comma for thousands
                    }
                },
                plotOptions: {
                    bar: {
                        colorByPoint: true // Assign colors to each bar individually
                    }
                },
                series: [{
                    name: 'Amount',
                    data: billData,
                    colors: Highcharts.getOptions().colors // Use the Highcharts color palette
                }]
            });
        })
        .catch(error => console.error(error));
</script>
@endsection
