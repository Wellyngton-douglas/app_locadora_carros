<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key">{{t.titulo}}</th>
                    <th v-if="botoes.atualizar.visivel || botoes.remover.visivel"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                    <td v-for="valor, chaveValor in obj" :key="chaveValor">
                        <span v-if="titulos[chaveValor].tipo == 'texto'">{{valor}}</span>
                        <span v-if="titulos[chaveValor].tipo == 'data'">
                            {{ format(new Date(valor), 'dd/MM/yyyy HH:mm:ss') }}
                        </span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="'/storage/'+valor" width="40" height="30">
                        </span>
                        <span v-if="titulos[chaveValor].tipo == 'condicao'">
                            <span v-if="valor == '1'">
                                Sim
                            </span>
                            <span v-else>
                                Não
                            </span>
                        </span>
                    </td>
                    <td v-if="botoes.atualizar.visivel || botoes.remover.visivel">
                        <button v-if="botoes.atualizar.visivel" class="btn btn-outline-primary btn-sm" :data-bs-toggle="botoes.atualizar.dataToggle" :data-bs-target="botoes.atualizar.dataTarget" @click="setStore(obj)">Atualizar</button>
                        <button v-if="botoes.remover.visivel" class="btn btn-outline-danger btn-sm" :data-bs-toggle="botoes.remover.dataToggle" :data-bs-target="botoes.remover.dataTarget" @click="setStore(obj)">Remover</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import { format, formatDistance, formatRelative, subDays } from 'date-fns'
    export default {
        data() {
            return {
                format
            }
        },
        props: ['dados', 'titulos', 'botoes'],
        methods: {
            // formatDatTime(dt) {
            //     return new Intl.DateTimeFormat('default', {dateStyle: 'long'}).format(dt);
            // },
            setStore(obj) {
                this.$store.state.transacao.status = ''
                this.$store.state.transacao.mensagem = ''
                this.$store.state.transacao.dados = ''
                this.$store.state.item = obj
                console.log(obj)
            }
        },
        computed: {
            dadosFiltrados() {
                let colunas = Object.keys(this.titulos) //pegar a chave dos titulos que foi passado
                let dadosFiltrados = []

                this.dados.map((item, chave) => {
                    let itemFiltrado = {}
                    colunas.forEach(campo => {
                        itemFiltrado[campo] = item[campo]
                        //utilizar a sintaxe de array para atribuir valores a objetos
                    })
                    dadosFiltrados.push(itemFiltrado)
                })

                return dadosFiltrados //retorne um array de objetos 
            }
        }
    }
</script>
