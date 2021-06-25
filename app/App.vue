<script>
	export default {
		onLaunch: function() {
			console.log('App Launch');
			const updateManager = uni.getUpdateManager();
			// 检查小程序是否有新版本发布
			updateManager.onCheckForUpdate(function(res) {
				// 请求完新版本信息的回调
				console.log(res.hasUpdate);
			});
			// 小程序有新版本，则静默下载新版本，做好更新准备
			updateManager.onUpdateReady(function(res) {
				uni.showModal({
					title: '更新提示',
					content: '新版本已经准备好，点击确定重新启动',
					showCancel: false,
					success(res) {
						if (res.confirm) {
							// 新的版本已经下载好，调用 applyUpdate 应用新版本并重启
							updateManager.applyUpdate();
						}
					}
				});
			});
			updateManager.onUpdateFailed(function(res) {
				// 新的版本下载失败
				uni.showModal({
					title: '已经有新版本了哟~',
					content: '新版本下载失败，请您删除当前小程序，重新搜索打开哟~'
				});

			});

		},
		onShow: function() {
			console.log('App Show')
		},
		onHide: function() {
			console.log('App Hide')
		}
	}
</script>

<style lang="scss">
	@import "uview-ui/index.scss";
	/*每个页面公共css */
</style>
