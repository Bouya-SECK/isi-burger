pipeline {
    agent any

    stages {

        stage('Pull Code') {
            steps {
                git branch: 'bouya_seck_burger',
                    url: 'https://github.com/TON_USERNAME/isi-burger.git'
            }
        }

        stage('Install Dependencies') {
            steps {
                sh 'composer install --no-interaction --prefer-dist'
                sh 'cp .env.example .env'
                sh 'php artisan key:generate'
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t isi-burger:latest .'
            }
        }

        stage('Deploy') {
            steps {
                sh 'docker stop isi-burger || true'
                sh 'docker rm isi-burger || true'
                sh 'docker run -d --name isi-burger -p 8000:80 isi-burger:latest'
            }
        }
    }

    post {
        success {
            echo 'Deploiement reussi !'
        }
        failure {
            echo 'Erreur lors du deploiement !'
        }
    }
}
