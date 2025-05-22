pipeline {
    agent any

    environment {
        SLACK_WEBHOOK = credentials('slack-webhook')  // Match the ID you created
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
    
    post {
        success {
            slackSend (webhookUrl: "${SLACK_WEBHOOK}", message: "✅ *Build SUCCESS* for ${env.JOB_NAME} #${env.BUILD_NUMBER}")
        }
        failure {
            slackSend (webhookUrl: "${SLACK_WEBHOOK}", message: "❌ *Build FAILED* for ${env.JOB_NAME} #${env.BUILD_NUMBER}")
        }
    }
}
