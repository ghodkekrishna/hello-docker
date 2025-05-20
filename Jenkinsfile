pipeline {
    agent any

    stages {
        stage('Clone') {
            steps {
                git branch: 'main', url: 'https://github.com/ghodkekrishna/hello-docker.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    dockerImage = docker.build("myapp:latest")
                }
            }
        }

        stage('Run Container') {
            steps {
                sh "docker rm -f myapp || true"
                sh "docker run -d --name myapp -p 8081:80 myapp:latest"
            }
        }
    }
}
