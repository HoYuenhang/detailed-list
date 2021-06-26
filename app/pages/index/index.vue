<template>
	<view class="project">
		<u-navbar :is-back="false" title="清单"></u-navbar>
		<u-row>
			<u-col :span="span" :offset="offset">
				<view style="width: 100%;" class="header">
					<view class="aisatsu">
						<view class="name">
							{{aisatsu}}
						</view>
						<view class="info">
							是一个清单呀
						</view>
					</view>
					<view class="newProject">
						<view style="width: 100%;">
							<u-input :custom-style="submitInputStyle" v-model="newProject" type="text" border="border"
								placeholder="请输入新建的项目" />
						</view>
						<u-button :custom-style="submitBtnStyle" @click="submitNewProject" shape="square"
							:ripple="true">
							新建</u-button>
					</view>
				</view>
				<view class="myProject">
					<view v-if="unfinishCount != 0" class="unFinish">
						<view style="margin: 15px 10px;" class="line">
							<view style="font-size: 18px;color: gray;">未完成</view>
							<u-line color="lightgray" margin="10px auto" />
						</view>
						<view v-for="(item,index) in unFinishProjectData" class="unfinishBox">
							<view class="unfinishItem">
								<u-icon @click="isFinish(item.listId,true)" size="18px" color="gray" name="star">
								</u-icon>
								<view class="text">{{item.title}}</view>
								<view class="operation">
									<view @click="goCategory(item.category)" v-if="item.category" class="category">
										#{{item.category}}
									</view>
									<view @click="doModify(item.listId)" class="modify">
										修改
									</view>
									<view @click="openModal('delete',item.listId)" class="delete">
										删除
									</view>
								</view>
							</view>
						</view>
						<u-loadmore @loadmore="loadmore('unFinish')" margin-top="10" :status="unfinishStatus" />
					</view>
					<view v-if="finishCount != 0" class="finished">
						<view style="margin: 15px 10px;" class="line">
							<view style="font-size: 18px;color: gray;">已完成</view>
							<u-line color="lightgray" margin="10px auto" />
						</view>
						<view v-for="(item,index) in finishProjectData" class="unfinishBox">
							<view class="finishedItem">
								<u-icon @click="isFinish(item.listId,false)" size="18px" color="gray" name="star-fill">
								</u-icon>
								<view class="text">{{item.title}}</view>
								<view class="operation">
									<view @click="goCategory(item.category)" v-if="item.category" class="category">
										#{{item.category}}
									</view>
									<view @click="doModify(item.listId)" class="modify">
										修改
									</view>
									<view @click="openModal('delete',item.listId)" class="delete">
										删除
									</view>
								</view>
							</view>
						</view>
						<u-loadmore @loadmore="loadmore('finished')" margin-top="10" :status="finishedStatus" />
					</view>
					<!-- <u-loading :show="showLoading" mode="circle"></u-loading> -->
				</view>
			</u-col>
		</u-row>
		<u-top-tips :navbar-height="statusBarHeight + navbarHeight" ref="uTips"></u-top-tips>
		<u-toast ref="uToast" />
		<u-modal v-model="showDeleteModal" :show-cancel-button="true" @confirm="doDelete()" :async-close="true"
			content="确定要删除此项吗？"></u-modal>
		<u-back-top :scroll-top="scrollTop">
		</u-back-top>
	</view>
</template>

<script>
	import request from '../../common/api.js'
	export default {
		data() {
			return {
				scrollTop: 0,
				span: 12,
				offset: 0,
				uuid: '',
				token: '',
				finishCount: 0, // 已完成项目的数量
				finishProjectData: [], // 已完成的项目
				unfinishCount: 0, // 未完成的项目数量
				unFinishProjectData: [], // 未完成的项目
				aisatsu: '', // 打招呼
				newProject: '', // 新建项目输入框
				showLoading: false, // 加载动画
				// 状态栏高度，H5中，此值为0，因为H5不可操作状态栏
				statusBarHeight: uni.getSystemInfoSync().statusBarHeight,
				// 导航栏内容区域高度，不包括状态栏高度在内
				navbarHeight: 44,
				// 提交按钮样式
				submitBtnStyle: {
					marginLeft: '10px',
					backgroundColor: '#4d8ef6',
					color: 'white',
					borderRadius: '10px'
				},
				// 提交输入框样式
				submitInputStyle: {
					height: '38px',
					width: '100%'
				},
				showDeleteModal: false, // 显示删除模态框
				opListId: '', // 需要操作的listId
				unfinishPage: 1, // 未完成页数
				finishedPage: 1, // 已完成页数
				unfinishStatus: 'loadmore', // 未完成加载更多状态
				finishedStatus: 'loadmore', // 已完成加载更多状态
			}
		},
		methods: {
			// 加载更多
			loadmore(op) {
				if (op == 'unFinish') {
					this.unfinishStatus = 'loading'
					this.unfinishPage += 1
				}
				if (op == 'finished') {
					this.finishedStatus = 'loading'
					this.finishedPage += 1
				}
				this.getProject(op)
			},
			// 打开模态框
			openModal(op, listId) {
				this.opListId = listId
				if (op == 'delete') {
					this.showDeleteModal = true
				}
				if (op == 'modify') {

				}
			},
			// 修改项目内容
			doModify() {
				return
			},
			// 删除项目
			doDelete() {
				// 获取listId
				var listId = this.opListId
				// 发起请求
				var doDelete = request.api.doDelete
				var uuid = this.uuid
				var token = this.token
				this.$utils.request(doDelete.url, doDelete.method, {
					listId: listId
				}, uuid, token).then((res) => {
					this.$refs.uToast.show({
						title: '删除成功',
						type: 'success',
						duration: 1500
					})
					this.getProject()
				}, (reason) => {
					this.$refs.uToast.show({
						title: '删除失败，请重试',
						type: 'error',
						duration: 1500
					})
				})
				// 把要操作的opListId置空
				this.opListId = ''
				// 关闭Modal
				this.showDeleteModal = false
			},
			// 跳转category页
			goCategory(category) {
				return
				uni.navigateTo({
					url: '../category/category?category=' + category
				})
			},
			// 用户点击 完成 / 未完成
			isFinish(listId, finish) {
				var modifyStatus = request.api.modifyStatus
				this.$utils.request(modifyStatus.url, modifyStatus.method, {
					listId: listId,
					isFinish: finish ? 1 : 0
				}, this.uuid, this.token).then((res) => {
					// 发出提示音

					this.getProject()
				}, (reason) => {
					// console.log(reason)
					this.$refs.uTips.show({
						title: '更新失败,请重试!',
						type: 'error',
						duration: '1500'
					})
				})
				this.getProject()
			},
			// 新建项目
			submitNewProject() {
				if (this.newProject == '') {
					this.$refs.uTips.show({
						title: '输入框不能为空',
						type: 'warning',
						duration: '1500'
					})
					return
				}
				var newProject = request.api.newProject
				var uuid = this.uuid
				var token = this.token
				this.$utils.request(newProject.url, newProject.method, {
					title: this.newProject
				}, uuid, token).then((res) => {
					// console.log(res)
					this.$refs.uToast.show({
						title: '新建成功',
						type: 'success',
						duration: 1500
					})
					this.newProject = ''
					this.getProject()
				}, (reason) => {
					this.$refs.uToast.show({
						title: '未知错误',
						type: 'error',
						duration: 1500
					})
				})
			},
			// 问候框信息
			aisatsuInfo() {
				var username = uni.getStorageSync('username')
				this.aisatsu = username ? username : '匿名用户'
				var hour = new Date().getHours() + 1
				if (hour >= 1 && hour <= 6) this.aisatsu += "，别熬夜"
				if (hour > 6 && hour <= 12) this.aisatsu += "，上午好"
				if (hour > 12 && hour <= 18) this.aisatsu += "，下午好"
				if (hour > 18 && hour <= 24) this.aisatsu += "，晚上好"
			},
			// 获取清单数据
			getProject(op = 'none') {
				var that = this
				var getProject = request.api.getProject
				this.$utils.request(getProject.url, getProject.method, {
					unfinishPage: op == 'none' ? 1 : that.unfinishPage,
					finishedPage: op == 'none' ? 1 : that.finishedPage,
					uuid: that.uuid
				}, that.uuid, that.token).then((res) => {
					// console.log(res)
					// loadmore状态执行
					if (op != 'none') {
						console.log(true)
						if (op == 'unFinish') {
							console.log('unFinish')
							that.unFinishProjectData = that.unFinishProjectData.concat(res.data.unFinished)
						}
						if (op == 'finished') {
							console.log('finished')
							that.finishProjectData = that.finishProjectData.concat(res.data.finished)
						}
						if (res.data.finished.length < 10 && op == 'finished') {
							// 已完成数据少于10条
							that.finishedStatus = 'nomore'
						} else if (res.data.unFinished.length < 10 && op == 'unFinish') {
							// 未完成数据少于10条
							that.unfinishStatus = 'nomore'
						} else {
							// 都有数据
							that.unfinishStatus = 'loadmore'
							that.finishedStatus = 'loadmore'
						}
					} else {
						console.log(false)
						that.finishedStatus = 'loadmore'
						that.unfinishStatus = 'loadmore'
						that.unFinishProjectData = res.data.unFinished
						that.finishProjectData = res.data.finished
						that.finishCount = res.data.finished.length
						that.unfinishCount = res.data.unFinished.length
					}
				}, (reason) => {
					console.log(reason)
					uni.removeStorageSync('token')
					this.$refs.uToast.show({
						title: 'token过期，请重新登录',
						type: 'error',
						duration: 1500
					})
					setTimeout(() => {
						uni.redirectTo({
							url: '../login/login'
						})
					}, 1500)
				})
			},
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
				this.span = 4
				this.offset = 4
			}
			this.uuid = uni.getStorageSync('uuid')
			this.token = uni.getStorageSync('token')
			this.getProject()
		},
		onLoad() {
			this.aisatsuInfo()
		},
		onPullDownRefresh() {
			this.getProject()
			uni.stopPullDownRefresh()
		},
		onPageScroll(e) {
			this.scrollTop = e.scrollTop;
		},
	}
</script>

<style lang="scss" scoped>
	.project {
		padding: 20px 15px;
	}

	.header {
		width: 100%;
		margin: 0 auto;
		background-color: #f3f4f7;
		border-radius: 20px;
	}

	.aisatsu {
		border-radius: 20px;
		padding: 15px;
	}

	.name {
		font-size: 20px;
		padding: 8px 10px;
	}

	.info {
		border: 1px solid #e6e6e6;
		padding: 15px;
		text-align: center;
		font-size: 16px;
	}

	// .u-input {
	// 	background-color: white;
	// }

	.newProject {
		width: 100%;
		display: flex;
		flex-direction: row;
		padding: 0 15px 15px;
	}

	// .noData {
	// 	width: 110px;
	// 	margin: 0 auto;
	// 	padding: 10px;
	// 	text-align: center;
	// 	font-size: 15px;
	// 	color: gray;
	// 	border-radius: 10px;
	// 	border: 1px solid lightgray;
	// }

	.finished,
	.unFinish {
		width: 100%;
	}

	.finishedItem,
	.unfinishItem {
		padding: 10px;
		border-radius: 15px;
		display: flex;
		flex-direction: row;
	}

	.finishedItem:hover,
	.unfinishItem:hover {
		background-color: #f5f5f5;
	}

	.finishedItem .text,
	.unfinishItem .text {
		color: #808080;
		margin-left: 10px;
		font-size: 14px;
		line-height: 24px;
	}

	.operation {
		font-size: 12px;
		margin-left: auto;
		display: flex;
		flex-direction: row;
	}

	.operation .category {
		color: #555555;
		margin-right: 5px;
		padding: 2px 5px;
		border: 1px solid #C9C9C9;
		border-radius: 3px;
	}

	.operation .modify,
	.operation .delete {
		color: #555555;
		margin-left: 5px;
		padding: 2px 5px;
		border: 1px solid #C9C9C9;
		border-radius: 10px;
	}
</style>
