# README #

## Utilizando o projeto pelo Docker

Em primeiro lugar é necessário ter o docker e o docker-compose instalados em sua máquina, para isso segue o tutorial:

* [Tutorial de instalação do docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/)
* [Tutorial de instalação do docker-compose](https://docs.docker.com/compose/install/)

### Configuração inicial
Para iniciar o projeto pela **primeira vez**, basta rodar os comandos abaixo a partir da pasta raiz da aplicação:

Para ambiente de **desenvolvimento**:
```shell
./laravel-docker start
./bin/setup.sh
```

Para ambiente de **homologação**:
```shell
./laravel-docker start homolog
./bin/setup.sh
```

> **Atenção!** Uma vez configurado, você **não precisará mais executar o script `setup.sh`**.
Em vez disso, você precisará se preocupar apenas em subir e derrubar o ambiente.

### Subir o ambiente
```shell
./laravel-docker start # Para ambiente de desenvolvimento
```

Caso você esteja subindo um ambiente de homologação, utilize o seguinte comando:
```shell
./laravel-docker start homolog # Para ambiente de homologação
```

### Derrubar o ambiente
```shell
./laravel-docker stop
```

### Limpar o ambiente
Este comando irá derrubar o ambiente, limpar os container órfãos e derrubar a rede interna do ambiente de desenvolvimento. Utilize-o com cuidado.
```shell
./laravel-docker clean
```

Para mais informações sobre o laravel-docker, acesse a [página de documentação do laravel-docker](https://github.com/danilopinotti/laravel-docker-environment)
