$(function() {
    const loadChart = () => {
        axios.get(`/api/dashboard/arsip/chart-data`)
            .then(async res => {
                let label = [];
                let series = [];

                await res.data.data.forEach(item => {
                    label.push(item.formatted_date);
                    series.push(item.count)
                })

                var options = {
                	series: [{
                		name: 'Arsip diunggah',
                		data: series
                	}],
                	chart: {
                		height: 400,
                		type: 'bar',
                	},
                	plotOptions: {
                		bar: {
                            borderRadius: 10,
                			dataLabels: {
                				position: 'top', // top, center, bottom
                			},
                		}
                	},
                	dataLabels: {
                		enabled: true,
                		formatter: function (val) {
                			return val;
                		},
                		offsetY: -20,
                		style: {
                			fontSize: '12px',
                			colors: ["#304758"]
                		}
                	},

                	xaxis: {
                		categories: label,
                		position: 'bottom',
                		axisBorder: {
                			show: false
                		},
                		axisTicks: {
                			show: false
                		},
                		crosshairs: {
                			fill: {
                				type: 'gradient',
                				gradient: {
                					colorFrom: '#D8E3F0',
                					colorTo: '#BED1E6',
                					stops: [0, 100],
                					opacityFrom: 0.4,
                					opacityTo: 0.5,
                				}
                			}
                		},
                		tooltip: {
                			enabled: true,
                		}
                	},
                	yaxis: {
                		axisBorder: {
                			show: false
                		},
                		axisTicks: {
                			show: false,
                		},
                		labels: {
                			show: false,
                			formatter: function (val) {
                				return val;
                			}
                		}

                	}
                };

                var chart = new ApexCharts(document.querySelector(".amp-pxl"), options);
                chart.render();
            })
    }
    const loadTop5Klasifikasi = () => {
        $('#klasifikasi-top5').html('')
        const colors = ['primary', 'secondary', 'info', 'warning', 'danger', 'success'];
        axios.get(`/api/dashboard/klasifikasi/top5`)
            .then(res => {
                res.data.data.forEach(item => {
                    let color = colors[Math.floor(Math.random()*colors.length)];
                    if(item.arsip_count > 0) {
                        $('#klasifikasi-top5').append(`
                            <div class="py-3 d-flex align-items-center">
                                <span class="btn btn-${color} btn-circle d-flex align-items-center">
                                    &nbsp;
                                </span>
                                <div class="ms-3">
                                    <a href="/admin/kode-klasifikasi/detail/${item.id}">
                                        <h5 class="mb-0 fw-bold">${item.kode}</h5>
                                        <span class="text-muted fs-6">${item.nama}</span>
                                    </a>
                                </div>
                                <div class="ms-auto">
                                    <span class="badge bg-light text-muted">${item.arsip_count} arsip</span>
                                </div>
                            </div>
                        `)
                    }
                })
            })
    }

    const lampiranParser = (lampiran) => {
        if(['image/jpeg', 'image/png'].includes(lampiran.type)) {
            return `<img src="${lampiran.url}" class="avatars__img" />`
        } else if(['video/mp4'].includes(lampiran.type)) {
            return `<img src="/assets/images/mp4.png" class="avatars__img" />`
        } else if(['application/pdf'].includes(lampiran.type)) {
            return `<img src="/assets/images/pdf.png" class="avatars__img" />`
        } else {
            return `<span class="avatars__others">+${lampiran.url}</span>`
        }
    }

    const statusParser = (status) => {
        switch (status) {
            case '1':
                return '<span class="badge bg-warning">Draft</span>';

            case '2':
                return '<span class="badge bg-success">Terpublikasi</span>';
                
            case '3':
                return '<span class="badge bg-danger text-light">Dihapus</span>';
        
            default:
                break;
        }
    }

    const loadLast5Arsip = () => {
        axios.get(`/api/dashboard/arsip/last5`)
            .then(res => {
                let counter = 1
                res.data.data.forEach(item => {
                    $('#arsip-table>tbody').append(`
                            <tr role="button" data-id="${item.id}">
                                <td>${item.nomor ? item.nomor : ''}</td>
                                <td>${item.admin_id ? item.admin.name : ''}</td>
                                <td class="nowrap-td">
                                    ${item.klasifikasi_id
                                        ? `
                                            <span class="badge bg-primary">
                                                ${item.klasifikasi.kode} | ${item.klasifikasi.nama}
                                            </span>
                                        `
                                        : ''
                                    }
                                </td>
                                <td>
                                    <small class="d-inline-block text-truncate" style="max-width: 250px;">${item.informasi ? item.informasi : ''}</small>
                                </td>
                                <td>
                                    <ul class="avatars">
                                        ${item.lampirans.map(l => lampiranParser(l)).join('')}
                                    </ul>
                                </td>
                                <td>${item.pencipta ? item.pencipta : ''}</td>
                                <td>${item.tanggal ? item.tanggal_formatted : ''}</td>
                                <td>${statusParser(item.status)}</td>
                                <td>${item.level == '2'
                                ? `<span class="badge bg-success">Publik</span>`
                                : `<span class="badge bg-danger">Rahasia</span>`
                                }</td>
                            </tr>
                        `)
                })
            })
    }

    loadChart();
    loadTop5Klasifikasi();
    loadLast5Arsip();

    $(document).on('click', 'tr', function() {
        let id = $(this).data('id');
        if(id) {
            window.location.href = '/dashboard/arsip/detail/'+id;
        }
    })
})