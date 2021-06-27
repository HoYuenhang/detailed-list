// 封装异步请求
function request(url, method, data, uuid, token) {
	return new Promise((resolve, reject) => {
		uni.request({
			url: url,
			header: {
				'content-type': 'application/x-www-form-urlencoded',
				'uuid': uuid,
				'token': token
			},
			method: method,
			data: data,
			success: (res) => {
				var result = {
					code: res.data.code,
					msg: res.data.msg,
					data: res.data.data
				}
				if (res.data.code == 200) {
					resolve(result)
				} else {
					reject(result)
				}
			},
			fail: (res) => {
				var result = {
					code: 500,
					msg: res.data.msg,
					data: '可能是网络错误'
				}
				reject(result)
			},
			complete: () => {
				// console.log('请求终了')
			}
		})
	})
}

module.exports = {
	request
}
