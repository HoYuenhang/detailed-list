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
									<view @click="showCategoryPopUp = true,currentCategory = item.category"
										v-if="item.category" class="category">
										#{{item.category}}
									</view>
									<view @click="openModal('modify',item.listId,item.title + ' ' + item.category)"
										class="modify">
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
									<view @click="showCategoryPopUp = true,currentCategory = item.category"
										v-if="item.category" class="category">
										#{{item.category}}
									</view>
									<view @click="openModal('modify',item.listId,item.title + ' ' + item.category)"
										class="modify">
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
				</view>
			</u-col>
		</u-row>
		<u-top-tips :navbar-height="statusBarHeight + navbarHeight" ref="uTips"></u-top-tips>
		<u-toast ref="uToast" />
		<u-modal z-index="10076" v-model="showDeleteModal" :show-cancel-button="true" @confirm="doDelete()"
			:async-close="true" content="确定要删除此项吗？"></u-modal>
		<u-back-top :scroll-top="scrollTop"></u-back-top>
		<u-popup z-index="10076" height="50%" @close="showModifyWarning = false,modifyProject = ''"
			:safe-area-inset-bottom="true" :closeable="true" mode="bottom" border-radius="40" v-model="showModifyModal">
			<view class="modifyInfo">
				<view class="modifyTitle">
					修改
				</view>
				下方输入框输入以修改
			</view>
			<view class="modifyInput">
				<view style="width: 100%;">
					<u-input :custom-style="submitInputStyle" v-model="modifyProject" type="text" border="border"
						placeholder="改成什么呢？" />
				</view>
				<u-button :custom-style="submitBtnStyle" @click="doModify" shape="square" :ripple="true">
					修改</u-button>
			</view>
			<view v-if="showModifyWarning" class="modifyInputNoData">
				输入框不能为空!
			</view>
			<view :style="!showModifyWarning ? 'padding: 8px 25px;color: gray;' : 'padding: 0px 25px;color: gray;'">
				需要添加标签用空格隔开即可，现只可添加一个标签
				<text>\n例：复习日语 学习</text>
			</view>
		</u-popup>
		<u-popup height="85%" @open="getCategoryProject"
			@close="showCategoryPopUp = false,currentCategory = '',categoryFinishData = [],categoryUnFinishData = [],getProject()"
			:safe-area-inset-bottom="true" :closeable="true" mode="bottom" border-radius="40"
			v-model="showCategoryPopUp">
			<view style="z-index: 1;position: fixed;top: 0;width: 100%;background-color: white;height: 40px;">

			</view>
			<view class="categoryInfo">
				<view class="categoryTitle">
					标签 #{{currentCategory}}
				</view>
				以下是 {{currentCategory}} 标签下所有的项目
			</view>
			<view class="categoryProject">
				<view class="unFinish">
					<view style="margin: 15px 10px;" class="line">
						<view style="font-size: 18px;color: gray;">未完成</view>
						<u-line color="lightgray" margin="10px auto" />
					</view>
					<view v-for="(item,index) in categoryUnFinishData" class="unfinishBox">
						<view class="unfinishItem">
							<u-icon @click="isFinish(item.listId,true)" size="18px" color="gray" name="star">
							</u-icon>
							<view class="text">{{item.title}}</view>
							<view class="operation">
								<view @click="openModal('modify',item.listId,item.title + ' ' + item.category)"
									class="modify">
									修改
								</view>
								<view @click="openModal('delete',item.listId)" class="delete">
									删除
								</view>
							</view>
						</view>
					</view>
				</view>
				<view class="finished">
					<view style="margin: 15px 10px;" class="line">
						<view style="font-size: 18px;color: gray;">已完成</view>
						<u-line color="lightgray" margin="10px auto" />
					</view>
					<view v-for="(item,index) in categoryFinishData" class="unfinishBox">
						<view class="finishedItem">
							<u-icon @click="isFinish(item.listId,false)" size="18px" color="gray" name="star-fill">
							</u-icon>
							<view class="text">{{item.title}}</view>
							<view class="operation">
								<view @click="openModal('modify',item.listId,item.title + ' ' + item.category)"
									class="modify">
									修改
								</view>
								<view @click="openModal('delete',item.listId)" class="delete">
									删除
								</view>
							</view>
						</view>
					</view>
				</view>
				<u-loadmore margin-bottom="20" status="nomore" />
			</view>
		</u-popup>
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
				modifyProject: '', // 修改项目输入框
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
				showModifyModal: false, // 显示修改弹出层
				showDeleteModal: false, // 显示删除模态框
				showModifyWarning: false, // 显示修改输入框错误信息
				opListId: '', // 需要操作的listId
				unfinishPage: 1, // 未完成页数
				finishedPage: 1, // 已完成页数
				unfinishStatus: 'loadmore', // 未完成加载更多状态
				finishedStatus: 'loadmore', // 已完成加载更多状态
				showCategoryPopUp: false, // 显示分类popup
				currentCategory: '', // 用户点击的分类
				categoryUnFinishData: [], // 分类popup中未完成数据
				categoryFinishData: [], // 分类popup中已完成数据
			}
		},
		methods: {
			// 获取某分类数据
			getCategoryProject() {
				var getCategoryProject = request.api.getCategoryProject
				var uuid = this.uuid
				var token = this.token
				uni.showLoading({
					title: '加载中...'
				})
				this.$utils.request(getCategoryProject.url, getCategoryProject.method, {
					category: this.currentCategory,
					uuid: uuid
				}, uuid, token).then((res) => {
					this.categoryUnFinishData = res.data.unFinished
					this.categoryFinishData = res.data.finished
					uni.hideLoading()
				}, (reason) => {
					console.log(reason)
					uni.hideLoading()
					this.$refs.uToast.show({
						title: '获取失败，请重试',
						type: 'error',
						duration: 1500
					})
				})
			},
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
			openModal(op, listId, title = '') {
				this.opListId = listId
				if (op == 'delete') {
					this.showDeleteModal = true
				}
				if (op == 'modify') {
					this.modifyProject = title
					this.showModifyModal = true
				}
			},
			// 修改项目内容
			doModify(op) {
				// 获取listId
				var listId = this.opListId
				// 验证输入框数据
				if (this.modifyProject == '') {
					this.showModifyWarning = true
					return
				}
				// 发起请求
				var doModify = request.api.doModify
				var uuid = this.uuid
				var token = this.token
				this.$utils.request(doModify.url, doModify.method, {
					listId: listId,
					title: this.modifyProject
				}, uuid, token).then((res) => {
					this.showModifyModal = false
					// 分类操作时执行
					if (this.currentCategory != '') {
						this.getCategoryProject()
					} else {
						this.getProject()
					}
					this.$refs.uToast.show({
						title: '修改成功',
						type: 'success',
						duration: 1500
					})
				}, (reason) => {
					console.log(reason)
					this.$refs.uToast.show({
						title: '修改失败，请重试',
						type: 'error',
						duration: 1500
					})
				})
			},
			// 删除项目
			doDelete(op) {
				// 获取listId
				var listId = this.opListId
				// 发起请求
				var doDelete = request.api.doDelete
				var uuid = this.uuid
				var token = this.token
				this.$utils.request(doDelete.url, doDelete.method, {
					listId: listId
				}, uuid, token).then((res) => {
					// 分类操作时执行
					if (this.currentCategory != '') {
						this.getCategoryProject()
					} else {
						this.getProject()
					}
					this.$refs.uToast.show({
						title: '删除成功',
						type: 'success',
						duration: 1500
					})
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
			// 用户点击 完成 / 未完成
			isFinish(listId, finish) {
				var modifyStatus = request.api.modifyStatus
				this.$utils.request(modifyStatus.url, modifyStatus.method, {
					listId: listId,
					isFinish: finish ? 1 : 0
				}, this.uuid, this.token).then((res) => {
					// 发出提示音

					// 分类操作时执行
					if (this.currentCategory != '') {
						this.getCategoryProject()
					} else {
						this.getProject()
					}
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
				// 验证输入框数据
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
				uni.showLoading({
					title: '加载中...'
				})
				this.$utils.request(getProject.url, getProject.method, {
					unfinishPage: op == 'none' ? 1 : that.unfinishPage,
					finishedPage: op == 'none' ? 1 : that.finishedPage,
					uuid: that.uuid
				}, that.uuid, that.token).then((res) => {
					// console.log(res)
					uni.stopPullDownRefresh()
					// loadmore状态执行
					if (op != 'none') {
						if (op == 'unFinish') {
							that.unFinishProjectData = that.unFinishProjectData.concat(res.data.unFinished)
						}
						if (op == 'finished') {
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
						// 无op时执行
						that.unfinishPage = 1
						that.finishedPage = 1
						that.finishedStatus = 'loadmore'
						that.unfinishStatus = 'loadmore'
						that.unFinishProjectData = res.data.unFinished
						that.finishProjectData = res.data.finished
						that.finishCount = res.data.finished.length
						that.unfinishCount = res.data.unFinished.length
					}
					uni.hideLoading()
				}, (reason) => {
					uni.stopPullDownRefresh()
					uni.hideLoading()
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
		onPullDownRefresh() {
			this.getProject()
		},
		onPageScroll(e) {
			this.scrollTop = e.scrollTop;
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

	.newProject {
		width: 100%;
		display: flex;
		flex-direction: row;
		padding: 0 15px 15px;
	}

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

	.categoryTitle,
	.modifyTitle {
		padding: 0 0 10px;
		font-size: 20px;
		font-weight: bold;
	}

	.categoryInfo,
	.modifyInfo {
		font-size: 16px;
		padding: 40px 25px 0;
	}

	.modifyInput {
		padding: 20px 25px 0;
		display: flex;
		flex-direction: row;
	}

	.modifyInputNoData {
		padding: 10px 15px 5px;
		color: red;
	}

	.categoryProject {
		padding: 0 15px;
	}
</style>
