/*
Template Name: Admin Pro Admin
Author: Wrappixel
Email: niravjoshi87@gmail.com
File: js
*/
$(function () {
  "use strict";
  // ==============================================================
  // Newsletter
  // ==============================================================

  var chart2 = new Chartist.Bar(
    ".amp-pxl",
    {
      labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30],
      series: [
        [9, 5, 3, 7, 5, 10, 3, 9, 5, 3, 7, 5, 10, 3, 9, 5, 3, 7, 5, 10, 3, 9, 5, 3, 7, 5, 10, 3, 8, 7],
      ],
    },
    {
      axisX: {
        // On the x-axis start means top and end means bottom
        position: "end",
        showGrid: false,
        axisTitle: 'Agustus'
      },
      axisY: {
        // On the y-axis start means left and end means right
        position: "start",
      },
      high: "12",
      low: "0",
      plugins: [Chartist.plugins.tooltip()],
    }
  );

  var chart = [chart2];
});
