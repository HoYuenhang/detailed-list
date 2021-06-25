// development
// const domain = 'http://127.0.0.1:8000'

// production
const domain = 'https://api.kksan.top'

const api = {
	// 登录
	login: {
		url: domain + '/Login',
		method: 'POST'
	},
	// 注册
	register: {
		url: domain + '/userRegister',
		method: 'POST'
	},
	// 免验证登录
	freeLogin: {
		url: domain + '/freeLogin',
		method: 'POST'
	},
	// 获取项目数据
	getProject: {
		url: domain + '/getProject',
		method: 'GET'
	},
	// 新建项目
	newProject: {
		url: domain + '/newProject',
		method: 'POST'
	},
	// 更改项目状态
	modifyStatus: {
		url: domain + '/modifyStatus',
		method: 'POST'
	},
	// 删除项目
	doDelete: {
		url: domain + '/doDelete',
		method: 'POST'
	},
	// 修改项目
	doModify: {
		url: domain + '/doModify',
		method: 'POST'
	}
}

module.exports = {
	api
}
