pipeline {
    agent any

    environment {
        SLACK_WEBHOOK = credentials('SLACK_WEBHOOK')
        IMAGE_NAME = 'ghodkekrishna/hello-docker'
    }

    stages {
        stage('Clone') {
            steps {
                git branch: 'main', url: 'https://github.com/ghodkekrishna/hello-docker.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    dockerImage = docker.build("${IMAGE_NAME}:latest")
                }
            }
        }

        stage('Push to Docker Hub') {
            steps {
                script {
                    docker.withRegistry('https://index.docker.io/v1/', 'docker-hub-creds') {
                        dockerImage.push('latest')
                    }
                }
            }
        }

        stage('Run Container') {
            steps {
                sh "docker rm -f myapp || true"
                sh "docker run -d --name myapp -p 8081:80 ${IMAGE_NAME}:latest"
            }
        }
    }

    post {
        success {
            sh """
              curl -X POST -H 'Content-type: application/json' \\
              --data '{"text":"✅ *Build SUCCESS* for ${env.JOB_NAME} #${env.BUILD_NUMBER}"}' \\
              ${SLACK_WEBHOOK}
            """
        }
        failure {
            sh """
              curl -X POST -H 'Content-type: application/json' \\
              --data '{"text":"❌ *Build FAILED* for ${env.JOB_NAME} #${env.BUILD_NUMBER}"}' \\
              ${SLACK_WEBHOOK}
            """
        }
    }
}
