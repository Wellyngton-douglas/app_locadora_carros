<template>
	<div>
		<label :for="id" class="form-label">{{titulo}}</label>
		<slot>
			<!-- usado para pegar o conteudo que esta sendo passado entre o component -->
		</slot>
		<div :id="idHelp" class="form-text text-muted">{{textoAjuda}}</div>
	</div>

</template>

<script>
	export default {
		props: ['id', 'titulo', 'idHelp', 'textoAjuda'],
	}
</script>
