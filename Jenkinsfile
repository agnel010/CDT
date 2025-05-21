pipeline {
    agent any

    environment {
        DOCKER_HOST = 'tcp://host.docker.internal:2375' // Docker daemon for Jenkins
    }

    stages {
        stage('Clone') {
            steps {
                git branch: 'main', url: 'https://github.com/agnel010/CDT.git'
            }
        }

        stage('Build App Image') {
            steps {
                sh 'docker build -t my-cdt-app .'
            }
        }

        stage('Run Containers') {
            steps {
                sh 'docker-compose -f docker-compose.yml up -d --build'
            }
        }

        stage('Wait for App') {
            steps {
                echo 'Waiting for app to start...'
                sh 'sleep 15' // Or use curl loop to check readiness
            }
        }

        stage('Run Selenium Tests') {
            steps {
                sh '''
                    docker build -f Dockerfile.selenium -t selenium-runner .
                    docker run --rm selenium-runner
                '''
            }
        }
    }

    post {
        always {
            echo 'Stopping and removing containers...'
            sh 'docker-compose down'
        }
    }
}
