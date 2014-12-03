<div ng-app="ngGravityForms">
	<div ng-controller="FormsCtrl">
		<form ng-submit="formSubmit()" ng-hide="showConfirm">
			<input type="text" ng-model="formData.input_1">
			<button type="submit">Click Me</button>
		</form>
		<p ng-show="showConfirm">
			<?php echo $form['confirmations']['545d0e770d90d']['message']; ?>
		</p>
	</div>
</div>