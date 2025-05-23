pipeline {
    agent any

    environment {
        SLACK_WEBHOOK = credentials('SLACK_WEBHOOK')
        BACKEND_IMAGE = 'krishnaghodke90/hello-docker-backend'
        FRONTEND_IMAGE = 'krishnaghodke90/hello-docker-frontend'
        DOCKER_HUB_CREDENTIALS = credentials('docker-hub-creds')
    }

    stages {
        stage('Clone') {
            steps {
                git branch: 'main', url: 'https://github.com/ghodkekrishna/hello-docker.git'
            }
        }

        stage('Build Backend Image') {
            steps {
                script {
                    backendImage = docker.build("${BACKEND_IMAGE}:latest", ".")
                }
            }
        }

        stage('Build Frontend Image') {
            steps {
                script {
                    frontendImage = docker.build("${FRONTEND_IMAGE}:latest", "./frontend")
                }
            }
        }

        stage('Push Images') {
            steps {
                withCredentials([usernamePassword(credentialsId: 'docker-hub-creds', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                    script {
                        sh "echo $DOCKER_PASS | docker login -u $DOCKER_USER --password-stdin"
                        sh "docker push ${BACKEND_IMAGE}:latest"
                        sh "docker push ${FRONTEND_IMAGE}:latest"
                    }
                }
            }
        }

        stage('Deploy') {
            steps {
                sh 'docker compose down || true'
                sh 'docker compose up -d'
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
