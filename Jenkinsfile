pipeline {
    agent any

    environment {
        SLACK_WEBHOOK = credentials('SLACK_WEBHOOK')
        IMAGE_NAME = 'krishnaghodke90/hello-docker'
        DOCKER_HUB_CREDENTIALS = credentials('docker-hub-creds')
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
                    docker.withRegistry('https://index.docker.io/v1/', DOCKER_HUB_CREDENTIALS) {
                        dockerImage.push('latest')
                    }
                }
            }
        }

        stage('Deploy Application') {
            steps {
                sh 'docker-compose down || true'
                sh 'docker-compose up -d'
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
