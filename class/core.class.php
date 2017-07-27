<?php

/* This is the last class in the chain */

class core {

    public function new_mysql($sql) {
            $result = $this->linkID->query($sql) or die($this->linkID->error);
            return $result;
    }

    // converts an StdObject to an Array
    public function objectToArray($d) {
            if (is_object($d)) {
                    // Gets the properties of the given object
                    // with get_object_vars function
                    $d = get_object_vars($d);
            }

            if (is_array($d)) {
                    /*
                    * Return array converted to object
                    * Using __FUNCTION__ (Magic constant)
                    * for recursive call
                    */
                    //return array_map(__FUNCTION__, $d);
                    return array_map(array($this, 'objectToArray'), $d);
            } else {
                    // Return array
                    return $d;
            }
    } // public function objectToArray($d)

    public static function FileExt($contentType)
    {
        $map = array(
            'application/pdf'   => '.pdf',
            'application/zip'   => '.zip',
            'image/gif'         => '.gif',
            'image/jpeg'        => '.jpg',
            'image/png'         => '.png',
            'text/css'          => '.css',
            'text/html'         => '.html',
            'text/javascript'   => '.js',
            'text/plain'        => '.txt',
            'text/xml'          => '.xml',
        );
        if (isset($map[$contentType]))
        {
            return $map[$contentType];
        }

        // HACKISH CATCH ALL (WHICH IN MY CASE IS
        // PREFERRED OVER THROWING AN EXCEPTION)
        $pieces = explode('/', $contentType);
        return '.' . array_pop($pieces);
    }

    /*
    $id = distinct name for the chart no spaces
    $data = json data {name: value},{name2: $value2}
    $title = Chart Title
    */
    public function pie_chart($id,$data,$title) {
        $pie_chart = "
        <script>
        var chart1; // globally available
        $(function() {
            chart1 = Highcharts.chart('$id', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '$title'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                name: '$name',
                colorByPoint: true,
                data: [
                ";
                $pie_chart .= $data;

                $pie_chart .= "
                ]
            }]
        });
    });
        </script>
        ";
        return($pie_chart);
    }

} // class core
?>
