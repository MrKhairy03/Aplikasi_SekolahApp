(function () {
    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + "").replace(",", "").replace(" ", "");
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
            dec = typeof dec_point === "undefined" ? "." : dec_point,
            s = "",
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return "" + Math.round(n * k) / k;
            };

        s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || "").length < prec) {
            s[1] = s[1] || "";
            s[1] += new Array(prec - s[1].length + 1).join("0");
        }
        return s.join(dec);
    }

    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById("myAreaChart");
        if (!ctx) return;

        if (typeof Chart === "undefined") {
            console.error(
                "Chart.js belum diload. Pastikan Chart.min.js dipanggil sebelum chart-area.js"
            );
            return;
        }

        // ==== Set default font: kompatibel v2 dan v3/v4 ====
        try {
            // v2
            if (Chart.defaults && Chart.defaults.global) {
                Chart.defaults.global.defaultFontFamily =
                    'Nunito, -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                Chart.defaults.global.defaultFontColor = "#858796";
            }
            // v3/v4
            else if (Chart.defaults) {
                Chart.defaults.font = Chart.defaults.font || {};
                Chart.defaults.font.family =
                    'Nunito, -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                Chart.defaults.color = "#858796";
            }
        } catch (e) {
            console.warn("Tidak bisa set default Chart font:", e);
        }

        var dataObj = window.dashboardChartData || null;
        if (!dataObj || !Array.isArray(dataObj.labels)) {
            console.error(
                "window.dashboardChartData tidak ditemukan / format salah."
            );
            return;
        }

        var labels = dataObj.labels || [];
        var products = dataObj.products || [];
        var sellers = dataObj.sellers || [];

        // ==== Detect Chart.js major version ====
        var majorVersion = 2;
        try {
            if (Chart.version) {
                majorVersion =
                    parseInt(String(Chart.version).split(".")[0], 10) || 2;
            }
        } catch (e) {}

        // ==== Build options by version ====
        var optionsV2 = {
            maintainAspectRatio: false,
            layout: { padding: { left: 10, right: 25, top: 25, bottom: 0 } },
            scales: {
                xAxes: [
                    {
                        gridLines: { display: false, drawBorder: false },
                        ticks: { maxTicksLimit: 12 },
                    },
                ],
                yAxes: [
                    {
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function (value) {
                                return number_format(value);
                            },
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2],
                        },
                    },
                ],
            },
            legend: { display: true },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: "#6e707e",
                titleFontSize: 14,
                borderColor: "#dddfeb",
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: true,
                intersect: false,
                mode: "index",
                caretPadding: 10,
                callbacks: {
                    label: function (tooltipItem, chart) {
                        var datasetLabel =
                            chart.datasets[tooltipItem.datasetIndex].label ||
                            "";
                        return (
                            datasetLabel +
                            ": " +
                            number_format(tooltipItem.yLabel)
                        );
                    },
                },
            },
        };

        var optionsV3 = {
            maintainAspectRatio: false,
            layout: { padding: { left: 10, right: 25, top: 25, bottom: 0 } },
            scales: {
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: { maxTicksLimit: 12 },
                },
                y: {
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function (value) {
                            return number_format(value);
                        },
                    },
                    grid: {
                        color: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                    },
                },
            },
            plugins: {
                legend: { display: true },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    titleColor: "#6e707e",
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    padding: 15,
                    displayColors: true,
                    intersect: false,
                    mode: "index",
                    callbacks: {
                        label: function (context) {
                            var label = context.dataset.label || "";
                            var value = context.parsed.y;
                            return label + ": " + number_format(value);
                        },
                    },
                },
            },
        };

        var chartConfig = {
            type: "line",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Products (created)",
                        tension: 0.3, // v3
                        lineTension: 0.3, // v2 (ignored by v3)
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "rgba(78, 115, 223, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointBorderColor: "rgba(78, 115, 223, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: products,
                    },
                    {
                        label: "Sellers (created)",
                        tension: 0.3,
                        lineTension: 0.3,
                        backgroundColor: "rgba(28, 200, 138, 0.05)",
                        borderColor: "rgba(28, 200, 138, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(28, 200, 138, 1)",
                        pointBorderColor: "rgba(28, 200, 138, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(28, 200, 138, 1)",
                        pointHoverBorderColor: "rgba(28, 200, 138, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: sellers,
                    },
                ],
            },
            options: majorVersion >= 3 ? optionsV3 : optionsV2,
        };

        try {
            new Chart(ctx, chartConfig);
        } catch (e) {
            console.error("Gagal render chart:", e);
        }
    });
})();
