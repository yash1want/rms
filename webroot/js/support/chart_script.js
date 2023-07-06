$(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
    //-------------
    //- DONUT CHART - 1st
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var allcount =$('#all_count').val();
    var pending_count =$('#pending_count').val();
    var inprocess_count =$('#inprocess_count').val();
    var closed_count =$('#closed_count').val();

    //alert(allcount);return false;
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'All',
          'Pending',
          'Inprocess',
          'Closed',
          /*'Opera',
          'Navigator',*/
      ],
      datasets: [
        {
          data: [allcount,pending_count,inprocess_count,closed_count],
         /* backgroundColor : ['#f39c12','#00c0ef','#00a65a','#f56954','#3c8dbc', '#d2d6de'],*/
          backgroundColor : ['#00c0ef','#f39c12','#6610f2','#00a65a'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })



    //-------------
    //- PIE CHART - 2nd
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
   /* var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })*/


    //-------------
    //- PIE CHART - Ticket ISSUE TYPE 3rd
    //-------------
    var operational_count =$('#operational_count').val();
    var db_related_count =$('#db_related_count').val();
    var change_request_count =$('#change_request_count').val();
    var external_count =$('#external_count').val();
    var training_count =$('#training_count').val();
    var other_mod_count =$('#other_mod_count').val();
    var prog_related_count =$('#prog_related_count').val();

    var pieChartTickIssueTypeCanvas = $('#pieChartTickIssueType').get(0).getContext('2d')
    var pieTitData        = {
      labels: [
          'Operational',
		  'Training',
		  'Change Request',
          'Other',
          'External/Browser',
          'Database Related',
          'Program Related',
      ],
      datasets: [
        {
          data: [operational_count,training_count,change_request_count,other_mod_count,external_count,db_related_count,prog_related_count],
          backgroundColor : ['#d2d6de','#3c8dbc','#00a65a','#f56954','#00c0ef', '#f39c12','#6610f2'],
        }
      ]
    }
    var pieTitptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartTickIssueTypeCanvas, {
      type: 'pie',
      data: pieTitData,
      options: pieTitptions
    })



     //-------------
    //- PIE CHART - Ticket Module 4th
    //-------------
    var rms_count =$('#rms_count').val();
    var mpas_count =$('#mpas_count').val();

    var pieChartTickModCanvas = $('#pieChartTicketModule').get(0).getContext('2d')
    var pieTMData        = {
      labels: [
          'RMS',
          'MPAS',
      ],
      datasets: [
        {
          data: [rms_count,mpas_count],
          backgroundColor : ['#3c8dbc','#d2d6de'],
        }
      ]
    }
    var pieTMOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartTickModCanvas, {
      type: 'pie',
      data: pieTMData,
      options: pieTMOptions
    })




    
   
  })


$(function () {
    /* jQueryKnob */

    $('.knob').knob({
      /*change : function (value) {
       //console.log("change : " + value);
       },
       release : function (value) {
       console.log("release : " + value);
       },
       cancel : function () {
       console.log("cancel : " + this.value);
       },*/
      draw: function () {

        // "tron" case
        if (this.$.data('skin') == 'tron') {

          var a   = this.angle(this.cv)  // Angle
            ,
              sa  = this.startAngle          // Previous start angle
            ,
              sat = this.startAngle         // Start angle
            ,
              ea                            // Previous end angle
            ,
              eat = sat + a                 // End angle
            ,
              r   = true

          this.g.lineWidth = this.lineWidth

          this.o.cursor
          && (sat = eat - 0.3)
          && (eat = eat + 0.3)

          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value)
            this.o.cursor
            && (sa = ea - 0.3)
            && (ea = ea + 0.3)
            this.g.beginPath()
            this.g.strokeStyle = this.previousColor
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
            this.g.stroke()
          }

          this.g.beginPath()
          this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
          this.g.stroke()

          this.g.lineWidth = 2
          this.g.beginPath()
          this.g.strokeStyle = this.o.fgColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
          this.g.stroke()

          return false
        }
      }
    })
    /* END JQUERY KNOB */

    //INITIALIZE SPARKLINE CHARTS
    var sparkline1 = new Sparkline($('#sparkline-1')[0], { width: 240, height: 70, lineColor: '#92c1dc', endColor: '#92c1dc' })
    var sparkline2 = new Sparkline($('#sparkline-2')[0], { width: 240, height: 70, lineColor: '#f56954', endColor: '#f56954' })
    var sparkline3 = new Sparkline($('#sparkline-3')[0], { width: 240, height: 70, lineColor: '#3af221', endColor: '#3af221' })

    sparkline1.draw([1000, 1200, 920, 927, 931, 1027, 819, 930, 1021])
    sparkline2.draw([515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921])
    sparkline3.draw([15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21])

  })