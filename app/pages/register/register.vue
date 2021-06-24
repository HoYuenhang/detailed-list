<template>
	<view class="sun-index">
		<u-navbar back-text="返回登录" title="注册"></u-navbar>
		<view class="sun-logo-box">
			<view class="sun-logo">
				<image class="sun-icon-img" src="@/static/login/logo.png" />
			</view>
		</view>

		<u-row>
			<u-col :span="span" :offset="offset">
				<!-- <view class="sun-login-box">
					<view class="sun-label">
						<image style="width: 17px;height:17px;" src="@/static/login/mobile.png" />
						<text class="label-text">手机</text>
					</view>
					<view class="sun-input-box">
						<input v-model="mobile" type="number" maxlength="11" placeholder="请输入手机号"
							placeholder-class="placeholder-class" />
						<image @click="mobile=''" class="close-icon" src="@/static/login/close_icon.png" />
					</view>
				</view> -->
				<view class="sun-login-box">
					<view class="sun-label">
						<image style="width: 17px;height:17px;" src="@/static/login/account.png" />
						<text class="label-text">用户名</text>
					</view>
					<view class="sun-input-box">
						<input v-model="username" type="text" placeholder="请输入用户名"
							placeholder-class="placeholder-class" />
						<image @click="username=''" class="close-icon" src="@/static/login/close_icon.png" />
					</view>
				</view>
				<view class="sun-login-box">
					<view class="sun-label">
						<image style="width: 17px;height:17px;" src="@/static/login/password.png" />
						<text class="label-text">密码</text>
					</view>
					<view class="sun-input-box">
						<input v-model="password" type="password" placeholder="请输入密码"
							placeholder-class="placeholder-class" />
						<image @click="password=''" class="close-icon" src="@/static/login/close_icon.png" />
					</view>
				</view>
				<view class="sun-login-box">
					<view class="sun-label">
						<image style="width: 17px;height:17px;" src="@/static/login/password.png" />
						<text class="label-text">确认密码</text>
					</view>
					<view class="sun-input-box">
						<input v-model="passwordConfirm" type="password" placeholder="请再次密码"
							placeholder-class="placeholder-class" />
						<image @click="passwordConfirm=''" class="close-icon" src="@/static/login/close_icon.png" />
					</view>
				</view>
				<view class="login-btn-box">
					<view class="login-btn" @click="handleSubmit">注册</view>
				</view>
			</u-col>
		</u-row>
		<u-toast ref="uToast" />
	</view>
</template>

<script>
	import md5 from '../../common/md5.js'
	import request from '../../common/api.js'
	export default {
		data() {
			return {
				span: 12,
				offset: 0,
				// mobile: '',
				username: '',
				password: '',
				passwordConfirm: ''
			}
		},
		created() {
			// 获取客户端信息
			var clientWidth
			var platform
			uni.getSystemInfo({
				success: (res) => {
					platform = res.platform
					clientWidth = res.windowWidth
				}
			})
			// 客户端宽大于768小于992改变输入框占比
			if (clientWidth > 768 && clientWidth <= 992) {
				this.span = 10
				this.offset = 1
			}
			// 客户端宽大于992改变输入框占比
			if (clientWidth > 992) {
				this.span = 6
				this.offset = 3
			}
		},
		methods: {
			// 提交注册信息
			handleSubmit() {
				// 信息验证
				// if (!this.mobile) return this.$refs.uToast.show({
				// 	title: '请输入手机号',
				// 	type: 'warning',
				// 	duration: 1500
				// })
				// if (this.mobile.length != 11) return this.$refs.uToast.show({
				// 	title: '手机号码长度不符',
				// 	type: 'warning',
				// 	duration: 1500
				// })
				if (!this.username) return this.$refs.uToast.show({
					title: '请输入用户名',
					type: 'warning',
					duration: 1500
				})
				if (!this.password) return this.$refs.uToast.show({
					title: '请输入密码',
					type: 'warning',
					duration: 1500
				})
				if (this.password != this.passwordConfirm) return this.$refs.uToast.show({
					title: '两次输入的密码不一致',
					type: 'warning',
					duration: 1500
				})
				uni.vibrateShort()
				// 发起请求
				var register = request.api.register
				this.$utils.request(register.url, register.method, {
					username: this.username,
					password: md5.hex_md5(this.password),
					// phone_number: this.mobile
				}).then((res) => {
					// 请求成功
					if (res.code == 200) {
						this.$refs.uToast.show({
							title: '注册成功',
							type: 'success',
							duration: 1500
						})
						// 跳转回登录页面
						setTimeout(() => {
							uni.navigateBack({
								delta: 1
							})
						}, 1500)
					}
				}, (reason) => {
					// 请求失败
					if (reason.code == 500) {
						this.$refs.uToast.show({
							title: '服务器错误',
							type: 'error',
							duration: 1500
						})
					} else if (reason.code == 4001) {
						this.$refs.uToast.show({
							title: '用户名已存在',
							type: 'warning',
							duration: 1500
						})
					} else if (reason.code == 4002) {
						this.$refs.uToast.show({
							title: '手机号已存在',
							type: 'warning',
							duration: 1500
						})
					} else {
						this.$refs.uToast.show({
							title: '未知错误',
							type: 'error',
							duration: 1500
						})
					}
				})
				//#ifdef MP-WEIXIN
				// 获取页面栈
				// var pages = getCurrentPages();
				// var prevPage = pages[pages.length - 2]; // 上一个页面
				// 修改上一页的数据
				// prevPage.setData({
				// 	username: this.username
				// })
				//#endif
			}
		}
	}
</script>

<style scoped>
	.sun-logo-box {
		margin: 0 auto;
		display: flex;
		justify-content: center;
		align-items: center;
		width: 375px;
		height: 150px;
	}

	.sun-icon-img {
		width: 60px;
		height: 60px;
	}

	.sun-logo {
		display: flex;
		justify-content: center;
		align-items: center;
		width: 90px;
		height: 90px;
		border-radius: 15rpx;
		/* background-color: #12C8B9; */
		/* box-shadow: 0rpx 0rpx 30rpx rgba(18,200,185,0.5); */
	}

	.sun-logo image {
		width: 90px;
		height: 90px;
	}

	.close-icon {
		width: 18px;
		height: 17px;
	}

	.sun-login-box {
		padding: 10px 30px;
	}

	.sun-label {
		display: flex;
		align-items: center;
	}

	.label-text {
		margin-left: 8px;
		font-weight: 500;
		color: #272e2d;
		font-size: 15px;
	}

	.sun-input-box {
		display: flex;
		align-items: center;
		height: 50px;
		border-bottom: 1rpx solid #eee;
		padding: 0px 5px;
	}

	.sun-input-box input {
		flex: 1;
	}

	.placeholder-class {
		font-size: 15px;
		color: #C0C0C0;
	}

	.sun-tip {
		display: flex;
		justify-content: space-between;
		padding: 0rpx 34px;
	}

	.sun-tip-text {
		color: #30C6B3;
	}

	.login-btn-box {
		margin: 0 auto;
		width: 300px;
		padding: 25px 34px 0px;
	}

	.login-btn {
		height: 41px;
		border-radius: 20.5px;
		background-color: #2b85e4;
		box-shadow: -1px 12px 11px 0px rgba(105, 141, 225, 0.4);
		text-align: center;
		line-height: 41px;
		font-size: 18px;
		font-weight: 500;
		color: #fff;
	}

	.code-text {
		font-size: 14px;
		color: #30C6B3;
	}

	.gray {
		color: #C0C0C0;
	}
</style>
