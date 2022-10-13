<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key">{{t.titulo}}</th>
                    <th v-if="botoes.visualizar.visivel || botoes.atualizar.visivel || botoes.remover.visivel"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                    <td v-for="valor, chaveValor in obj" :key="chaveValor">
                        <span v-if="titulos[chaveValor].tipo == 'texto'">{{valor}}</span>
                        <span v-if="titulos[chaveValor].tipo == 'data'">{{valor}}</span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="'/storage/'+valor" width="40" height="30">
                        </span>
                    </td>
                    <td v-if="botoes.visualizar.visivel || botoes.atualizar.visivel || botoes.remover.visivel">
                        <button v-if="botoes.visualizar.visivel" class="btn btn-outline-primary btn-sm" :data-bs-toggle="botoes.visualizar.dataToggle" :data-bs-target="botoes.visualizar.dataTarget">Visualizar</button>
                        <button v-if="botoes.atualizar.visivel" class="btn btn-outline-primary btn-sm" :data-bs-toggle="botoes.atualizar.dataToggle" :data-bs-target="botoes.atualizar.dataTarget">Atualizar</button>
                        <button v-if="botoes.remover.visivel" class="btn btn-outline-danger btn-sm" :data-bs-toggle="botoes.remover.dataToggle" :data-bs-target="botoes.remover.dataTarget">Remover</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulos', 'botoes'],
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
