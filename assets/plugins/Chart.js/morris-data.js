// Dashboard 1 Morris-chart
$(function () {
    "use strict";
// Morris bar chart
    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: 'Jan',
            a: 1000,
            b: 90
        }, {
            y: 'Feb',
            a: 75,
            b: 65
        }, {
            y: 'Mar',
            a: 50,
            b: 40
        }, {
            y: 'Apr',
            a: 75,
            b: 65
        }, {
            y: 'Mei',
            a: 500,
            b: 40
        }, {
            y: 'Jun',
            a: 75,
            b: 65
        }, {
            y: 'Jul',
            a: 100,
            b: 90
        }, {
            y: 'Aug',
            a: 100,
            b: 90
        }, {
            y: 'Sept',
            a: 100,
            b: 90
        }, {
            y: 'Oct',
            a: 100,
            b: 90
        }, {
            y: 'Nov',
            a: 100,
            b: 90,
        }, {
            y: 'Dec',
            a: 100,
            b: 90
        },
        ],
        xkey: 'y',
        ykeys: ['a', 'b',],
        labels: ['UserAdd', 'UserText',],
        barColors:['#1E88E5', '#26C6DA'],
        hideHover: 'auto',
        gridLineColor: '#eef0f2',
        xLabelMargin: 0,
        resize: true
	}
	);
 });    
