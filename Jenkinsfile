pipeline {
    agent any

    environment {
        DOCKER_HOST = 'tcp://host.docker.internal:2375' // For Docker access from Jenkins
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

        stage('Run App Container') {
            steps {
                sh 'docker-compose -f docker-compose.yml up -d --build'
            }
        }

        stage('Wait for App to be Ready') {
            steps {
                echo 'Waiting for app to be ready...'
                sh '''
                    for i in {1..10}; do
                      if curl -s http://localhost:8085 > /dev/null; then
                        echo "App is up!"
                        break
                      fi
                      echo "Waiting..."
                      sleep 3
                    done
                '''
            }
        }

        stage('Run Selenium Tests') {
            steps {
                sh '''
                    docker build -f Dockerfile.selenium -t selenium-runner .
                    docker run --rm --network cdt-network selenium-runner
                '''
            }
        }
    }

    post {
        always {
            echo 'Cleaning up containers...'
            sh 'docker-compose down'
        }
    }
}
