<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Inicio card busca -->
				<card-component titulo="Busca Carros">
					<template v-slot:conteudo>
                        <div class="row">
                            <div class="col mb-3">
                                <input-container-component id="inputId" titulo="Nome do Modelo" id-help="novoModeloHelp" texto-ajuda="Informe o Nome do Modelo">
                                <select v-model="busca.modelo_id" class="form-select" aria-label="Default select example" @click="carregarListaModelo()">
                                    <option value="">Escolha um Modelo</option>
                                    <option v-for="modelo in modelos" :key="modelo.id" :value="modelo.id">
                                        {{ modelo.nome }}
                                    </option>
                                </select>
							</input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component id="placaHelp" titulo="Placa" id-help="placaHelp" texto-ajuda="Opcional. Informe a placa do Carro">
                                	<input type="text" class="form-control" id="inputPlaca" maxlength="8" aria-describedby="placaHelp" placeholder="Placa" v-model="busca.placa">
								</input-container-component>
                            </div>
                        </div>
                    </template>

					<template v-slot:rodape>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button type="submit" class="btn btn-primary" @click="pesquisar()">Pesquisar</button>
						</div>
                    </template>
				</card-component>
				<!-- Fim card busca -->

                <!-- Inicio card listagem-->
				<card-component titulo="Relatório de Carros">
                    <template v-slot:conteudo>
                        <table-component 
							:dados="carros.data"
							:botoes="botoes"
							:titulos="titulos">
                        </table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
							<div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in modelos.links" :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item'"
                                        @click="paginacao(l)">
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
							<div class="col">
								<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCarro">Adicionar</button>
							</div>
						</div>
                    </template>
                </card-component>
				<!-- Fim card listagem-->

                <!-- Inicio modal adicionar -->
				<modal-component id="modalCarro" title="Adicionar Carro">
					<template v-slot:alertas>
						<alert-component tipo="success" :detalhes="$store.state.transacao" titulo="Cadastro realizado com sucesso" v-if="$store.state.transacao.status == 'adicionado'"></alert-component>
						<alert-component tipo="danger" :detalhes="$store.state.transacao" titulo="Erro ao tentar cadastrar a marca" v-if="$store.state.transacao.status == 'erro'"></alert-component>
					</template>
					<template v-slot:conteudo v-if="$store.state.transacao.status != 'adicionado'">
						<div class="form">
							<div class="col mb-3">
								<input-container-component id="novoModelo" titulo="Nome do Modelo" id-help="novoModeloHelp" texto-ajuda="Informe o Nome do Modelo">
                                    <select v-model="modelo_id" class="form-select" aria-label="Default select example" @click="carregarListaModelo()">
                                        <option value="" disabled>Escolha um Modelo</option>
                                        <option v-for="modelo in modelos" :key="modelo.id" :value="modelo.id">
                                            {{ modelo.nome }}
                                        </option>
                                    </select>
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="placa" titulo="Placa" id-help="placaHelp" texto-ajuda="Informe a Placa do Veiculo">
									<input type="text" class="form-control" id="placa" aria-describedby="placaHelp" maxlength="8" placeholder="Placa" v-model="placa">
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="situacao" titulo="Situação" id-help="airBagHelp" texto-ajuda="Informe se esta disponivel">
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value=1 type="radio" name="disponivel" id="situacao1" v-model="disponivel" checked>
                                    <label class="form-check-label" for="situacao1">
                                        Sim
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value=0 type="radio" name="disponivel" id="situacao2" v-model="disponivel">
                                    <label class="form-check-label" for="situacao2">
                                        Não
                                    </label>
                                </div>
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="km" titulo="km" id-help="kmHelp" texto-ajuda="Informe a quilometragem do veiculo">
									<input type="number" class="form-control" id="km" min="1" max="8" aria-describedby="kmHelp" placeholder="Placa" v-model="km">
								</input-container-component>
							</div>
						</div>
					</template>
					<template v-slot:rodape>
						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
							<button type="button" class="btn btn-primary" @click="salvar()" v-if="$store.state.transacao.status != 'adicionado'">Salvar</button>
						</div>
					</template>
				</modal-component>
				<!-- Fim modal adicionar -->

                <!-- Inicio modal remover -->
				<modal-component id="modalCarroRemover" title="Remover Carro">
					<template v-slot:alertas>
						<alert-component tipo="success" :detalhes="$store.state.transacao" titulo="Transação realizada com sucesso" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
						<alert-component tipo="danger" :detalhes="$store.state.transacao" titulo="Erro na transação" v-if="$store.state.transacao.status == 'erro'"></alert-component>
					</template>
					<template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
						<input-container-component titulo="Placa do Carro">
							<input type="text" class="form-control" :value="$store.state.item.placa" disabled>
						</input-container-component>
					</template>
					<template v-slot:rodape>
						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
							<button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
						</div>
					</template>
				</modal-component>
				<!-- Fim modal remover -->

                <!-- Inicio modal editar -->
				<modal-component id="modalCarroAtualizar" title="Editar Carro">
					<template v-slot:alertas>
						<alert-component tipo="success" :detalhes="$store.state.transacao" titulo="Transação realizada com sucesso" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
						<alert-component tipo="danger" :detalhes="$store.state.transacao" titulo="Erro na transação" v-if="$store.state.transacao.status == 'erro'"></alert-component>
					</template>
					<template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
						<div class="form">
							<div class="col mb-3">
								<input-container-component id="modeloId" titulo="Nome do Modelo" id-help="modeloIdHelp" texto-ajuda="Informe o Nome do Modelo">
                                    <select v-model="$store.state.item.modelo_id" class="form-select" aria-label="Default select example" @click="carregarListaModelo()">
                                        <option value="" disabled>Escolha um Modelo</option>
                                        <option v-for="modelo in modelos" :key="modelo.id" :value="modelo.id">
                                            {{ modelo.nome }}
                                        </option>
                                    </select>
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="novaPlaca" titulo="Placa" id-help="novaPlacaHelp" texto-ajuda="Informe a Placa do Veiculo">
									<input type="text" class="form-control" id="novaPlaca" maxlength="8" aria-describedby="novaPlacaHelp" placeholder="Placa" v-model="$store.state.item.placa">
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="novaSituacao" titulo="Situação" id-help="novaSituacaoHelp" texto-ajuda="Informe se esta disponivel">
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value=1 type="radio" name="disponivel" id="novaSituacao1" v-model="$store.state.item.disponivel" checked>
                                    <label class="form-check-label" for="novaSituacao1">
                                        Sim
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value=0 type="radio" name="disponivel" id="novaSituacao2" v-model="$store.state.item.disponivel">
                                    <label class="form-check-label" for="novaSituacao2">
                                        Não
                                    </label>
                                </div>
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="novoKm" titulo="km" id-help="novoKmHelp" texto-ajuda="Informe a quilometragem do veiculo">
									<input type="number" class="form-control" id="novoKm" min="1" max="8" aria-describedby="novoKmHelp" placeholder="Placa" v-model="$store.state.item.km" disabled>
								</input-container-component>
							</div>
						</div>
					</template>
					<template v-slot:rodape>
						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
							<button type="button" class="btn btn-primary" @click="atualizar()" v-if="$store.state.transacao.status != 'sucesso'">Salvar</button>
						</div>
					</template>
				</modal-component>
				<!-- Fim modal editar -->

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
				urlBase: this.$store.state.configUrl.carros,
				urlPaginacao: '',
				urlFiltro: '',
                carros: { data: [] },
                modelos: { data: [] },
                titulos: {
                    id: {titulo: 'Número do Carro', tipo: 'texto'},
					modelo_id: {titulo: 'Número do Modelo', tipo: 'texto'},
					placa: {titulo: 'Placa', tipo: 'texto'},
					disponivel: {titulo: 'Situação', tipo: 'condicao'},
                    km: {titulo: 'KM', tipo: 'texto'},
					created_at: {titulo: 'Data de Criação', tipo: 'data'},
				},
                botoes: {
					atualizar: {visivel: true, dataToggle: 'modal', dataTarget: '#modalCarroAtualizar'},
					remover: {visivel: true, dataToggle: 'modal', dataTarget: '#modalCarroRemover'},
				},
                disponivel: 1,
                modelo_id: '',
                placa: '',
                km: 0,
                busca: { modelo_id: '', placa: '' }



            }
        },
        methods: {
            carregarLista() {
				let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
				axios.get(url)
					.then(response => {
						this.carros = response.data
						//console.log(this.carros)
					})
					.catch(errors => {
						console.log(errors)
					})
			},
            carregarListaModelo() {
                let url = this.$store.state.configUrl.modelos
                axios.get(url)
					.then(response => {
						this.modelos = response.data.data
						console.log(response.data.data)
					})
					.catch(errors => {
						console.log(errors)
					})
            },
            salvar() {
				let formData = new FormData();
				formData.append('modelo_id', this.modelo_id)
				formData.append('placa', this.placa)
                formData.append('disponivel', this.disponivel)
                formData.append('km', this.km)
                
				let config = {
					headers: {
						'Content-Type': 'multipart/form-data'
					}
				}

				axios.post(this.urlBase, formData, config)
					.then(response => {
                        this.$store.state.transacao.status = 'adicionado'
                        this.$store.state.transacao.mensagem = response.data.msg
                        this.carregarLista()
						console.log(response)
					})
					.catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.message
						console.log(errors)
					})				
			},
            remover() {
                let confirmacao = confirm('Tem certeza que deseja remover esse registro?')

                if(!confirmacao) {
                    return false;
                }

                let formData = new FormData();
                formData.append('_method', 'delete')

                let url = this.urlBase + '/' + this.$store.state.item.id

                axios.post(url, formData)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = response.data.msg
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.message
                        this.$store.state.transacao.dados = errors.response.data.errors
                    })

            },
            atualizar() {
                let formData = new FormData();
                formData.append('_method', 'patch')
                formData.append('modelo_id', this.$store.state.item.modelo_id)
				formData.append('placa', this.$store.state.item.placa)
                formData.append('disponivel', this.$store.state.item.disponivel)
                formData.append('km', this.$store.state.item.km)

                let url = this.urlBase + '/' + this.$store.state.item.id

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        console.log('Atualizado', response)
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'Registro de carro atualizado com sucesso'
                        this.carregarLista()
                    })
                    .catch(errors => {
                        console.log('Erro de atualização', errors.response)
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.message
                        this.$store.state.transacao.dados = errors.response.data.errors
                    })
            },
            paginacao(l) {
                if(l.url) {
                    this.urlPaginacao = l.url.split('?')[1] //retornando a paginação que foi clicada
                    this.carregarLista() //requisitando novamente os dados para nossa API
                }
            },
            pesquisar() {
				let filtro = ''

				for(let chave in this.busca) {
					if(this.busca[chave] != '') {
						if(filtro != '') {
							filtro += ";"
						}
	
						filtro += chave + ':like:%' + this.busca[chave] + '%'
					}
				}

				if(filtro != '') {
					this.urlPaginacao = 'page=1'
					this.urlFiltro = '&filtro=' + filtro
				} else {
					this.urlFiltro = ''
				}

				this.carregarLista()

			}
        },
        mounted() {
            this.carregarLista(),
            this.carregarListaModelo()
        }
    }
</script>
