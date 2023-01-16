$(function() {
    let params = new URL(window.location.href).searchParams;

    const loadChart = () => {
        axios.get(`/api/dashboard/arsip/chart-data?start=${params.get('start')}&end=${params.get('end')}`)
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

    const loadHistoricalViewChart = () => {
        axios.get(`/api/dashboard/arsip/viewer-data?start=${params.get('start')}&end=${params.get('end')}`)
            .then(async res => {
                console.log(res)
                let label = [];
                let series = [];

                await res.data.data.forEach(item => {
                    label.push(item.formatted_date);
                    series.push(item.viewers)
                })

                var options = {
                	series: [{
                		name: 'Pengunjung',
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

                console.log(series);
                var chart = new ApexCharts(document.querySelector(".arsip-dilihat-chart"), options);
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
                                <div>
                                    <a href="/dashboard/kode-klasifikasi/detail/${item.id}">
                                        <h5 class="mb-0 fw-bold">${item.kode}</h5>
                                        <small class="text-muted">${item.nama ? item.nama.length > 50 ? item.nama.substr(0, 50)+"..." : item.nama : item.nama}</small>
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

    const loadTop5Arsip = () => {
        $('#arsip-top5').html('')
        axios.get(`/api/dashboard/arsip/top5`)
            .then(res => {
                res.data.data.forEach(item => {
                    $('#arsip-top5').append(`
                        <div class="pb-3">
                            <div class="d-flex align-items-center">
                                <div>
                                    <a href="/dashboard/arsip/detail/${item.id}">
                                        <h5 class="mb-0 fw-bold">#${item.nomor}</h5>
                                        <small class="text-muted">${item.informasi ? item.informasi.length > 50 ? item.informasi.substr(0, 50)+"..." : item.informasi : item.informasi}</small>
                                    </a>
                                </div>
                                <div class="ms-auto">
                                    <span class="badge bg-light text-muted">${item.viewers} arsip</span>
                                </div>
                            </div>
                            <small class="text-dark">Oleh: ${item.pencipta}</small>
                        </div>
                        `)
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
    loadHistoricalViewChart();
    loadTop5Klasifikasi();
    loadTop5Arsip();
    loadLast5Arsip();

    $(document).on('click', 'tr', function() {
        let id = $(this).data('id');
        if(id) {
            window.location.href = '/dashboard/arsip/detail/'+id;
        }
    })
})